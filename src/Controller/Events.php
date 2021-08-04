<?php
/**
 * Created by PhpStorm.
 * User: Vivien
 * Date: 18/09/2019
 * Time: 16:43
 */
namespace App\Controller;

final class Events
{
    /**
     * For the event naming conventions, see:
     * https://symfony.com/doc/current/components/event_dispatcher.html#naming-conventions.
     *
     * @Event("Symfony\Component\EventDispatcher\GenericEvent")
     *
     * @var string
     */
    const NEWSLETTER_SEND = 'newsletter.send';
}