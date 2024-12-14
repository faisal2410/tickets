<?php

$badgeColors = [
    'red' => 'bg-red-100 text-red-800',
    'green' => 'bg-green-100 text-green-800',
    'yellow' => 'bg-yellow-100 text-yellow-800',
    'gray' => 'bg-gray-100 text-gray-800',
];

// Helper function to get ticket status badge color
function getStatusColor(string $status): string
{
    global $badgeColors;

    return match($status) {
        'Open' => $badgeColors['red'],
        'In Progress' => $badgeColors['yellow'],
        'Resolved' => $badgeColors['green'],
        default => $badgeColors['gray']
    };
}

// Helper function to get ticket priority badge color
function getPriorityColor(string $priority): string
{
    global $badgeColors;

    return match($priority) {
        'High' => $badgeColors['red'],
        'Medium' => $badgeColors['yellow'],
        'Low' => $badgeColors['green'],
        default => $badgeColors['gray'],
    };
}