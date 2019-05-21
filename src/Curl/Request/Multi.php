<?php declare(strict_types=1);

namespace Stellar\Curl\Request;

use Stellar\Common\Identify;
use Stellar\Curl\Contracts\CurlResourceInterface;

class Multi implements CurlResourceInterface
{
    use EventDispatchable;

    /** @var resource */
    protected $_resource;

    /** @var array<int,mixed> */
    protected $_options = [];

    /** @var Request[] */
    protected $_requests = [];

    /** @var array<string,Request> */
    protected $_queue = [];

    /** @var int */
    protected $_queueTotal = 0;

    /** @var int */
    protected $_queueLeft = 0;

    /** @var array<string,array> */
    protected $_errors = [];

    /** @var int */
    protected $_passes = 0;

    /**
     * The interval by which the status of the requests is checked. The default is 300000
     * microseconds (= 0.3 seconds).
     *
     * @var int Interval in microseconds.
     * @see \usleep()
     */
    protected $_executeInterval = 300000;

    /** @var bool */
    protected $_executed = false;

    protected function _handleResult(array $info, int $status) : void
    {
        $error = $info['result'];
        $requestResourceId = Identify::resource($info['handle']);

        /** @var Request $request */
        $request = $this->_queue[ $requestResourceId ];
        unset($this->_queue[ $requestResourceId ]);

        if (\CURLE_OK !== $error) {
            $this->_errors[ $requestResourceId ] = $error;
        }

        // process the received response
        $request->processMultiResponse($this->_resource, $error);
        \curl_multi_remove_handle($this->_resource, $request->getResource());
    }

    /** {@inheritdoc} */
    public function __destruct()
    {
        $this->close();
    }

    /**
     * @param Request[] $requests
     */
    public function __construct(array $requests = [])
    {
        if (!empty($requests)) {
            $this->_requests = $requests;
        }
    }

    /**
     * Add a Request object that should be executed.
     *
     * @return static
     */
    public function addRequest(Request $request) : self
    {
        $this->_requests[] = $request;

        return $this;
    }

    public function withExecuteInterval(int $microseconds = 300000) : self
    {
        $this->_executeInterval = $microseconds;

        return $this;
    }

    /**
     * Closure(Request $request, ?int $index) : ?bool
     *
     * @return static
     */
    public function forEach(\Closure $func) : self
    {
        foreach ($this->_requests as $index => $request) {
            $break = $func($request, $index);
            if (false === $break) {
                break;
            }
        }

        return $this;
    }

    /**
     * Get all added Request objects.
     *
     * @return Request[]
     */
    public function getRequests() : array
    {
        return $this->_requests;
    }

    /** {@inheritdoc} */
    public function hasOption(int $option) : bool
    {
        return \array_key_exists($option, $this->_options);
    }

    /** {@inheritdoc} */
    public function getOption(int $option)
    {
        return $this->_options[ $option ] ?? null;
    }

    /** {@inheritdoc} */
    public function getOptions() : array
    {
        return $this->_options;
    }

    /** {@inheritdoc} */
    public function getResource()
    {
        return $this->_resource;
    }

    public function getPasses() : int
    {
        return $this->_passes;
    }

    /** {@inheritdoc} */
    public function isExecuted() : bool
    {
        return $this->_executed;
    }

    /** {@inheritdoc} */
    public function isClosed() : bool
    {
        return $this->_executed && null === $this->_resource;
    }

    /**
     * Indicates if any of the request has errors.
     */
    public function hasErrors() : bool
    {
        return empty($this->_errors);
    }

    /** {@inheritdoc} */
    public function init() : self
    {
        if (null === $this->_resource) {
            $this->_resource = \curl_multi_init();
            foreach ($this->_requests as $request) {
                $requestResource = $request->init()->getResource();
                \curl_multi_add_handle($this->_resource, $requestResource);
                $this->_queue[ (string) $requestResource ] = $request;
            }
        }

        return $this;
    }

    /**
     * Closure(array $status) : void
     */
    public function execute() : self
    {
        $this->init();
        $this->_queueTotal = \count($this->_queue);
        $this->_queueLeft = $previouslyLeft = $this->_queueTotal;

        while ($this->_queueLeft > 0) {
            $this->_passes++;

            $status = \curl_multi_exec($this->_resource, $this->_queueLeft);
            \curl_multi_select($this->_resource);

            if ($this->_queueLeft !== $previouslyLeft) {
                $previouslyLeft = $this->_queueLeft;

                $info = \curl_multi_info_read($this->_resource);
                $this->_handleResult($info, $status);
            }

            \usleep($this->_executeInterval);
        }

        $this->_executed = true;

        return $this;
    }

    /** {@inheritdoc} */
    public function close() : void
    {
        if (null !== $this->_resource) {
            \curl_multi_close($this->_resource);
            $this->_resource = null;

            foreach ($this->_requests as $request) {
                $request->close();
            }
        }
    }
}
