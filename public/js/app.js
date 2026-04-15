const FANVERSE_SYSTEM_MODAL_ID = 'fanverseSystemModal';
const FANVERSE_MODAL_TRANSITION_MS = 180;
const fanverseModalQueue = [];
let fanverseModalActive = false;
let fanverseKeyHandlerRegistered = false;
const MTV_THEME_STORAGE_KEY = 'mtv-theme';
const MTV_THEME_DARK = 'dark';
const MTV_THEME_LIGHT = 'light';

function getActiveTheme() {
  return document.documentElement.getAttribute('data-theme') === MTV_THEME_DARK
    ? MTV_THEME_DARK
    : MTV_THEME_LIGHT;
}

function persistTheme(theme) {
  try {
    localStorage.setItem(MTV_THEME_STORAGE_KEY, theme);
  } catch (error) {
    // Ignore storage issues and keep the theme in memory only.
  }
}

function updateThemeToggleButtons(theme) {
  const isDark = theme === MTV_THEME_DARK;

  document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
    if (!(button instanceof HTMLElement)) {
      return;
    }

    const icon = button.querySelector('i');
    const label = button.querySelector('.theme-toggle__label');
    const nextLabel = isDark ? 'Modo claro' : 'Modo oscuro';

    button.setAttribute('aria-label', `Activar ${nextLabel.toLowerCase()}`);
    button.setAttribute('title', nextLabel);
    button.setAttribute('data-theme-state', theme);

    if (icon instanceof HTMLElement) {
      icon.classList.remove('fa-moon', 'fa-sun');
      icon.classList.add(isDark ? 'fa-sun' : 'fa-moon');
    }

    if (label instanceof HTMLElement) {
      label.textContent = nextLabel;
    }
  });
}

function applyTheme(theme) {
  const normalizedTheme = theme === MTV_THEME_DARK ? MTV_THEME_DARK : MTV_THEME_LIGHT;

  document.documentElement.setAttribute('data-theme', normalizedTheme);

  if (document.body instanceof HTMLElement) {
    document.body.setAttribute('data-theme', normalizedTheme);
  }

  updateThemeToggleButtons(normalizedTheme);

  return normalizedTheme;
}

function initializeThemeToggle() {
  const mediaQuery = window.matchMedia ? window.matchMedia('(prefers-color-scheme: dark)') : null;
  const storedTheme = (() => {
    try {
      return localStorage.getItem(MTV_THEME_STORAGE_KEY);
    } catch (error) {
      return null;
    }
  })();

  applyTheme(getActiveTheme());

  document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
    button.addEventListener('click', () => {
      const nextTheme = getActiveTheme() === MTV_THEME_DARK ? MTV_THEME_LIGHT : MTV_THEME_DARK;
      persistTheme(nextTheme);
      applyTheme(nextTheme);
    });
  });

  if (storedTheme === null && mediaQuery) {
    const syncTheme = (event) => {
      applyTheme(event.matches ? MTV_THEME_DARK : MTV_THEME_LIGHT);
    };

    if (typeof mediaQuery.addEventListener === 'function') {
      mediaQuery.addEventListener('change', syncTheme);
    } else if (typeof mediaQuery.addListener === 'function') {
      mediaQuery.addListener(syncTheme);
    }
  }
}

initializeThemeToggle();

function escapeFanverseHtml(value) {
  return String(value ?? '')
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#39;');
}

function formatFanverseMessage(message) {
  return escapeFanverseHtml(message).replace(/\r?\n/g, '<br>');
}

function getFanverseModalElement() {
  return document.getElementById(FANVERSE_SYSTEM_MODAL_ID);
}

function dismissFanverseSystemModal() {
  const modal = getFanverseModalElement();
  const state = modal ? modal._fanverseState : null;

  if (!state) {
    return;
  }

  resolveFanverseSystemModal(state.type === 'confirm' ? false : true);
}

function resolveFanverseSystemModal(accepted) {
  const modal = getFanverseModalElement();
  const state = modal ? modal._fanverseState : null;

  if (!modal || !state || state.closing) {
    return;
  }

  state.closing = true;
  modal.classList.remove('is-visible');
  modal.setAttribute('aria-hidden', 'true');
  document.body.classList.remove('fanverse-system-modal-open');

  window.setTimeout(() => {
    const latestState = modal._fanverseState;

    if (!latestState || latestState.id !== state.id) {
      return;
    }

    modal._fanverseState = null;

    if (state.activeElement && typeof state.activeElement.focus === 'function') {
      try {
        state.activeElement.focus({ preventScroll: true });
      } catch (error) {
        state.activeElement.focus();
      }
    }

    state.resolve(accepted);
  }, FANVERSE_MODAL_TRANSITION_MS);
}

function ensureFanverseSystemModal() {
  let modal = getFanverseModalElement();

  if (modal) {
    return modal;
  }

  modal = document.createElement('div');
  modal.id = FANVERSE_SYSTEM_MODAL_ID;
  modal.className = 'fanverse-system-modal';
  modal.setAttribute('aria-hidden', 'true');

  modal.innerHTML = `
    <div class="fanverse-system-modal__backdrop js-fanverse-backdrop"></div>
    <div class="fanverse-system-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="fanverseSystemModalTitle">
      <div class="fanverse-system-modal__content">
        <button type="button" class="fanverse-modal__close js-fanverse-close" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
        <div class="fanverse-system-modal__body">
          <span class="fanverse-modal__eyebrow js-fanverse-eyebrow">Mensaje del sistema</span>
          <h2 id="fanverseSystemModalTitle" class="js-fanverse-title">Aviso del sistema</h2>
          <p class="fanverse-modal__lead fanverse-modal__message js-fanverse-message"></p>
          <div class="fanverse-modal__summary js-fanverse-summary" hidden>
            <strong class="js-fanverse-summary-title"></strong>
            <p class="js-fanverse-summary-text mb-0"></p>
          </div>
          <div class="fanverse-modal__actions">
            <button type="button" class="btn fanverse-modal__action fanverse-modal__action--cancel js-fanverse-cancel">
              Cancelar
            </button>
            <button type="button" class="btn fanverse-modal__action fanverse-modal__action--primary js-fanverse-confirm">
              Aceptar
            </button>
          </div>
        </div>
      </div>
    </div>
  `;

  document.body.appendChild(modal);

  const refs = {
    backdrop: modal.querySelector('.js-fanverse-backdrop'),
    closeButton: modal.querySelector('.js-fanverse-close'),
    eyebrow: modal.querySelector('.js-fanverse-eyebrow'),
    title: modal.querySelector('.js-fanverse-title'),
    message: modal.querySelector('.js-fanverse-message'),
    summary: modal.querySelector('.js-fanverse-summary'),
    summaryTitle: modal.querySelector('.js-fanverse-summary-title'),
    summaryText: modal.querySelector('.js-fanverse-summary-text'),
    cancelButton: modal.querySelector('.js-fanverse-cancel'),
    confirmButton: modal.querySelector('.js-fanverse-confirm'),
  };

  modal._fanverseRefs = refs;

  refs.backdrop.addEventListener('click', dismissFanverseSystemModal);
  refs.closeButton.addEventListener('click', dismissFanverseSystemModal);
  refs.cancelButton.addEventListener('click', () => resolveFanverseSystemModal(false));
  refs.confirmButton.addEventListener('click', () => resolveFanverseSystemModal(true));

  if (!fanverseKeyHandlerRegistered) {
    document.addEventListener('keydown', (event) => {
      const activeModal = getFanverseModalElement();

      if (!activeModal || !activeModal.classList.contains('is-visible')) {
        return;
      }

      if (event.key === 'Escape') {
        event.preventDefault();
        dismissFanverseSystemModal();
      }
    });

    fanverseKeyHandlerRegistered = true;
  }

  return modal;
}

function getFanverseDefaults(type, message, options = {}) {
  const normalizedMessage = String(message ?? '').trim().toLowerCase();
  const isDeleteAction = normalizedMessage.includes('eliminar');

  if (type === 'confirm') {
    return {
      eyebrow: options.eyebrow ?? (isDeleteAction ? 'Accion sensible' : 'Confirmacion del sistema'),
      title: options.title ?? (isDeleteAction ? 'Eliminar registro' : 'Confirmar accion'),
      confirmText: options.confirmText ?? (isDeleteAction ? 'Eliminar' : 'Continuar'),
      cancelText: options.cancelText ?? 'Cancelar',
      variant: options.variant ?? (isDeleteAction ? 'danger' : 'primary'),
      summaryTitle: options.summaryTitle ?? (isDeleteAction ? 'Importante' : ''),
      summaryText: options.summaryText ?? (isDeleteAction ? 'Esta accion no se puede deshacer.' : ''),
    };
  }

  return {
    eyebrow: options.eyebrow ?? 'Mensaje del sistema',
    title: options.title ?? 'Aviso del sistema',
    confirmText: options.confirmText ?? 'Aceptar',
    cancelText: options.cancelText ?? 'Cancelar',
    variant: options.variant ?? 'primary',
    summaryTitle: options.summaryTitle ?? '',
    summaryText: options.summaryText ?? '',
  };
}

function drainFanverseModalQueue() {
  if (fanverseModalActive || fanverseModalQueue.length === 0) {
    return;
  }

  fanverseModalActive = true;
  const nextModal = fanverseModalQueue.shift();

  presentFanverseModal(nextModal.options)
    .then(nextModal.resolve)
    .finally(() => {
      fanverseModalActive = false;
      drainFanverseModalQueue();
    });
}

function queueFanverseModal(options) {
  return new Promise((resolve) => {
    fanverseModalQueue.push({ options, resolve });
    drainFanverseModalQueue();
  });
}

function presentFanverseModal(options) {
  const modal = ensureFanverseSystemModal();
  const refs = modal._fanverseRefs;
  const resolvedOptions = getFanverseDefaults(options.type, options.message, options);
  const activeElement = document.activeElement instanceof HTMLElement ? document.activeElement : null;

  refs.eyebrow.textContent = resolvedOptions.eyebrow;
  refs.title.textContent = resolvedOptions.title;
  refs.message.innerHTML = formatFanverseMessage(resolvedOptions.message);
  refs.confirmButton.textContent = resolvedOptions.confirmText;
  refs.cancelButton.textContent = resolvedOptions.cancelText;
  refs.cancelButton.hidden = resolvedOptions.type !== 'confirm';

  refs.confirmButton.classList.remove(
    'fanverse-modal__action--primary',
    'fanverse-modal__action--danger',
    'fanverse-modal__action--success'
  );
  refs.confirmButton.classList.add(`fanverse-modal__action--${resolvedOptions.variant}`);

  if (resolvedOptions.summaryTitle || resolvedOptions.summaryText) {
    refs.summary.hidden = false;
    refs.summaryTitle.textContent = resolvedOptions.summaryTitle;
    refs.summaryText.textContent = resolvedOptions.summaryText;
  } else {
    refs.summary.hidden = true;
    refs.summaryTitle.textContent = '';
    refs.summaryText.textContent = '';
  }

  return new Promise((resolve) => {
    modal._fanverseState = {
      id: Date.now() + Math.random(),
      resolve,
      type: resolvedOptions.type,
      activeElement,
      closing: false,
    };

    document.body.classList.add('fanverse-system-modal-open');
    modal.setAttribute('aria-hidden', 'false');

    window.requestAnimationFrame(() => {
      modal.classList.add('is-visible');
      refs.confirmButton.focus();
    });
  });
}

function showFanverseAlert(message, options = {}) {
  return queueFanverseModal({
    type: 'alert',
    message,
    ...options,
  });
}

function showFanverseConfirm(message, options = {}) {
  return queueFanverseModal({
    type: 'confirm',
    message,
    ...options,
  });
}

document.addEventListener(
  'submit',
  async (event) => {
    const form = event.target;

    if (!(form instanceof HTMLFormElement)) {
      return;
    }

    const confirmMessage = form.getAttribute('data-fanverse-confirm');
    if (!confirmMessage) {
      return;
    }

    event.preventDefault();

    const accepted = await showFanverseConfirm(confirmMessage, {
      eyebrow: form.getAttribute('data-fanverse-confirm-eyebrow') || undefined,
      title: form.getAttribute('data-fanverse-confirm-title') || undefined,
      confirmText: form.getAttribute('data-fanverse-confirm-accept') || undefined,
      cancelText: form.getAttribute('data-fanverse-confirm-cancel') || undefined,
      variant: form.getAttribute('data-fanverse-confirm-variant') || undefined,
      summaryTitle: form.getAttribute('data-fanverse-confirm-summary-title') || undefined,
      summaryText: form.getAttribute('data-fanverse-confirm-summary') || undefined,
    });

    if (accepted) {
      HTMLFormElement.prototype.submit.call(form);
    }
  },
  true
);

const nativeAlert = window.alert ? window.alert.bind(window) : null;
window.__fanverseNativeAlert = nativeAlert;
window.alert = function fanverseAlertOverride(message) {
  void showFanverseAlert(message);
};

window.showFanverseAlert = showFanverseAlert;
window.showFanverseConfirm = showFanverseConfirm;

async function vote(nominationId, itemId) {
  const params = new URLSearchParams();
  params.append('nomination_id', nominationId);
  params.append('item_id', itemId);

  try {
    const response = await fetch('/api/vote', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8',
      },
      body: params.toString(),
      credentials: 'same-origin',
    });

    const payload = await response.json().catch(() => ({}));

    if (response.ok && payload.ok) {
      await showFanverseAlert('Tu voto se registro correctamente.', {
        eyebrow: 'Portal en vivo',
        title: 'Voto registrado',
        variant: 'success',
        summaryTitle: 'Siguiente paso',
        summaryText: 'Al cerrar esta ventana se actualizara el conteo en pantalla.',
      });
      window.location.reload();
      return;
    }

    await showFanverseAlert(payload.error || 'No fue posible registrar tu voto.', {
      eyebrow: 'No se completo la accion',
      title: 'No se pudo continuar',
      variant: 'danger',
      summaryTitle: 'Revision rapida',
      summaryText: 'Verifica el estado de la nominacion o intenta nuevamente en unos segundos.',
    });
  } catch (error) {
    await showFanverseAlert('Ocurrio un problema al conectar con el servidor.', {
      eyebrow: 'Conexion interrumpida',
      title: 'Sin comunicacion',
      variant: 'danger',
      summaryTitle: 'Que hacer ahora',
      summaryText: 'Recarga la pagina o intenta de nuevo cuando la conexion se estabilice.',
    });
  }
}
