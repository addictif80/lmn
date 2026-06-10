<?php

namespace App\Enums;

enum QuoteStatus: string
{
    case Pending = 'pending';
    case Contacted = 'contacted';
    case Quoted = 'quoted';
    case Accepted = 'accepted';
    case Declined = 'declined';

    public function label(): string
    {
        return match($this) {
            self::Pending => 'En attente',
            self::Contacted => 'Contacté',
            self::Quoted => 'Devisé',
            self::Accepted => 'Accepté',
            self::Declined => 'Refusé',
        };
    }
}
