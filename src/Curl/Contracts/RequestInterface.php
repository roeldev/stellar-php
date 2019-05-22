<?php declare(strict_types=1);

namespace Stellar\Curl\Contracts;

interface RequestInterface
{
    /**
     * The magic `__destruct()` method should call the `close()` method so the resources are
     * properly closed and memory is freed.
     */
    public function __destruct();

    /**
     * Determine if the CURL option is configured for this request.
     */
    public function hasOption(int $option) : bool;

    /**
     * Get the value of the configured option or `null` when it doesn't exist.
     *
     * @return mixed
     */
    public function getOption(int $option);

    /**
     * Get all configured CURL options for this request.
     *
     * @return array<int,mixed>
     */
    public function getOptions() : array;

    /**
     * Returns the resource once the request is executed.
     *
     * @return ?resource
     */
    public function getResource();

    /**
     * Indicates if the request is executed.
     */
    public function isExecuted() : bool;

    /**
     * Indicates if the resource is closed after being executed.
     */
    public function isClosed() : bool;

    /**
     * Init creates and prepares the resource for execution when it's not already done, or when a
     * previous connection is closed. It's not required to call this method prior to calling
     * the `execute()` method.
     *
     * @return $this
     */
    public function init();

    /**
     * Execute the request and process the response. When the `init()` method is not yet called
     * the method will call it, thus preparing the request, before execution.
     *
     * @return $this
     */
    public function execute();

    /**
     * Close the resource(s) and free memory.
     */
    public function close() : void;
}
