<?php

namespace Queue;

class Module
{
    /**
     * @return mixed[]
     */
    public function getConfig(): array
    {
        $config = [];
        $configs = glob(__DIR__ . '/../config/*.config.php');

        if (false !== $configs) {
            foreach ($configs as $file) {
                $config = array_merge($config, include $file);
            }
        }

        return $config;
    }
}
