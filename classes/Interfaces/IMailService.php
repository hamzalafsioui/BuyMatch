<?php

interface IMailService
{
    public static function sendTicket(User $user, array $tickets);
}
