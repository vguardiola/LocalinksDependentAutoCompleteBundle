<?php

namespace Localinks\DependentAutoCompleteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('LocalinksDependentAutoCompleteBundle:Default:index.html.twig');
    }
}
