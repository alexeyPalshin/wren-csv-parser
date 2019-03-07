<?php


namespace Wren\Observers;


class ObserversLauncher
{
    /**
     * @var array
     */
    private $observers = array();

    /**
     * add observer
     *
     * @param callable $observer
     */
    public function addObserver($observer)
    {
        if (is_callable($observer)) {
            $this->observers[] = $observer;
        }
    }
    /**
     * notify to observers
     *
     * @param $line
     */
    public function launch($line)
    {
        $results = [];
        foreach ($this->observers as $observer) {
            $results[] = $this->delegate($observer, $line);
        }

        return !in_array(false, $results, true);
    }
    /**
     * delegate to observer
     *
     * @param $observer
     * @param $line
     */
    private function delegate($observer, $line)
    {
        return call_user_func($observer, $line);
    }
}