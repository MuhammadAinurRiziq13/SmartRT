<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public const SUCCESS_MESSAGE = 'Request successfully processed';
    public const ERROR_MESSAGE = 'Request failed. Please try again!';
    public const EXCEPTION_MESSAGE = 'Exception occured. Please try again!';

    public const SUCCESS_STATUS = 'success';
    public const ERROR_STATUS = 'error';

    public const SUCCESS = 200;
    public const ERROR = 500;
    public const VALIDATION_ERROR = 422;
}