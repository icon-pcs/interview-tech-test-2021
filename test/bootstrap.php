<?php

require_once __DIR__ . "/../vendor/autoload.php";

function now(): DateTimeImmutable
{
    return new DateTimeImmutable("now");
}

function tomorrow(): DateTimeImmutable
{
    return now()->add(new DateInterval("P1D"));
}

function yesterday(): DateTimeImmutable
{
    return now()->sub(new DateInterval("P1D"));
}

function inFiveSeconds(): DateTimeImmutable
{
    return now()->add(new DateInterval("PT5S"));
}
