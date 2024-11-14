<?php
use XponLmsPlugin\Controller\Page\OntSetupPageController;

/** @noinspection PhpUnhandledExceptionInspection */
XponLms::whereIsMyPlugin()->runPageController(OntSetupPageController::class);
