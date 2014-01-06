<?php

abstract class BaseAdminController extends Controller
{
    public function isAdmin() {
        return true;
    }
}
