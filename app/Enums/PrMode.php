<?php

namespace App\Enums;

enum PrMode: string
{
    case CompetitiveBidding = 'Competitive Bidding';
    case SelectiveBidding = 'Selective Bidding';
    case DirectContracting = 'Direct Contracting';
    case RepeatOrder = 'Repeat Order';
    case Shopping = 'Shopping';
    case NegotiatedProcurement = 'Negotiated Procurement';
}
