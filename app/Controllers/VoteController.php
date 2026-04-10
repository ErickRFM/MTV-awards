<?php

require_once __DIR__ . '/../Models/Vote.php';
require_once __DIR__ . '/../Models/Nomination.php';
require_once __DIR__ . '/../Models/NominationItem.php';

class VoteController
{
    public function create(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        if (empty($_SESSION['user'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Debes iniciar sesion para votar.']);
            return;
        }

        $userId = (int) $_SESSION['user']['id'];
        $nominationId = (int) ($_POST['nomination_id'] ?? 0);
        $itemId = (int) ($_POST['item_id'] ?? 0);

        $nomination = Nomination::find($nominationId);
        $item = NominationItem::find($itemId);

        if (!$nomination || !$item || (int) $item['nomination_id'] !== $nominationId) {
            http_response_code(400);
            echo json_encode(['error' => 'La nominacion o el nominado no son validos.']);
            return;
        }

        $now = date('Y-m-d H:i:s');
        if (
            $nomination['status'] !== 'active' ||
            ($nomination['start_date'] && $now < $nomination['start_date']) ||
            ($nomination['end_date'] && $now > $nomination['end_date'])
        ) {
            http_response_code(400);
            echo json_encode(['error' => 'La votacion no esta activa en este momento.']);
            return;
        }

        if (Vote::userVoted($userId, $nominationId)) {
            http_response_code(400);
            echo json_encode(['error' => 'Ya registraste tu voto para esta nominacion.']);
            return;
        }

        try {
            $voteId = Vote::create($userId, $nominationId, $itemId);
            echo json_encode(['ok' => true, 'vote_id' => $voteId]);
        } catch (Throwable $exception) {
            http_response_code(400);
            echo json_encode(['error' => 'No se pudo registrar el voto.']);
        }
    }
}
