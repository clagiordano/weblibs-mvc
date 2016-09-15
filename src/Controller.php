<?php

namespace clagiordano\weblibs\mvc;

/**
 * The Contoller is the C in MVC.
 * The base controller is a simple abstract class that defines the
 * structure of all controllers.
 * By including the registry here, the registry is available to all class
 * that extend from the base controller. An index() method has also been
 * included in the base controller which means all controller classes that
 * extend from it must have an index() method themselves.
 *
 * @author Claudio Giordano <claudio.giordano@autistici.org>
 */
abstract class Controller
{
    /** @var Application $application */
    protected $application;

    /** @var Request $application */
    protected $request = null;

    /**
     *
     * @param clagiordano\weblibs\mvc\Application $application
     * @return clagiordano\weblibs\mvc\Controller
     */
    public function __construct(Application $application)
    {
        $this->application = $application;

        $this->request = new Request();

        $this->application->getRegistry()->requestType = $this->request->getType();
        $this->application->getRegistry()->requestData = $this->request->getData();
    }

    /**
     * All controllers must implements an index method
     */
    abstract public function index();
}
