<?php

namespace clagiordano\weblibs\mvc;

/**
 *
 * @author Claudio Giordano <claudio.giordano@autistici.org>
 */
class Request
{
    /** @var array $requestData */
    private $requestData = null;
    /** @var string $requestType */
    private $requestType = null;

    private $requestTypesMap = [
        'GET' => 'Empty',
        'DELETE' => 'Empty',
        'POST' => 'Json',
        'PUT' => 'Json',
        'HEAD' => 'Empty',
        'OPTIONS' => 'Empty',
        'PATCH' => 'Empty',
        null => 'Empty',
    ];

    /**
     * @param array $requestData
     * @return \clagiordano\weblibs\mvc\Request
     */
    public function setData($requestData)
    {
        $this->requestData = $requestData;

        return $this;
    }

    /**
     * Returns parsed request data
     *
     * @return array
     */
    public function getData()
    {
        $this->parseRequest();

        return json_decode($this->requestData, true);
    }

    /**
     * Sets requests type
     *
     * @param string $requestType
     * @return
     */
    public function setType($requestType)
    {
        if (!isset($this->requestTypesMap[$requestType])) {
            throw new \InvalidArgumentException(
                __METHOD__ . ": Invalid request type"
            );
        }

        $this->requestType = $requestType;
    }

    /**
     * Parse and sets requestType and requestData proprerties after parsing.
     */
    private function parseRequest()
    {
        if (is_null($this->requestType)) {
            $this->requestType = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
        }

        if (!isset($this->requestTypesMap[$this->requestType])) {
            throw new \InvalidArgumentException(
                __METHOD__ . ": Invalid request type '{$this->requestType}'"
            );
        }

        if (is_null($this->requestData)) {
            $this->requestData = file_get_contents('php://input');
        }

        $this->setData(
                call_user_func(
                [
                    $this,
                    'parse' . $this->requestTypesMap[$this->requestType] . 'Data'
                ]
            )
        );
    }

    /**
     * Parse request empty callback
     * @return null
     */
    private function parseEmptyData()
    {
        return null;
    }

    /**
     * Parse request json callback
     * @return string
     */
    private function parseJsonData()
    {
        return $this->requestData;
    }
}
