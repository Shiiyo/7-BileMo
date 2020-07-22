<?php

namespace App\HATEOAS;

interface HATEOASGeneratorInterface
{
    public function selfLink();
    public function listLink();
    public function modifyLink();
    public function deleteLink();
}