<?php

use XponLmsPlugin\Controller\OntSearchServiceController;

/** @noinspection PhpUnhandledExceptionInspection */
(new OntSearchServiceController(XponLms::whereIsMyPlugin()))->run();
