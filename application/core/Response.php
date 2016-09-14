<?php
class Response
{

    private $headers = array();
    private $level = 0;
    private $output;
    /**
     *
     * @param string $header
     */
    public function addHeader($header)
    {
        $this->headers[] = $header;
    }
    /**
     *$header
     * @param string $url
     */
    public function redirect($url)
    {
        header('Location: ' . $url);
        exit;
    }
    /**
     *
     * @param int $template
     * @param array $data
     * @return string
     */
    public function view($template, $data = array())
    {
        $file = APP . 'view/' . $template;
        if (file_exists($file)) {
            extract($data);
            ob_start();
            require($file);
            $output = ob_get_contents();
            ob_end_clean();
            return $output;
        } else {
            trigger_error('Error: Could not load template ' . $file . '!');
            exit();
        }
    }
    /**
     *
     * @param string $output
     */
    public function setOutput($output)
    {
        $this->output = $output;
    }
    /**
     *
     * @param string $data
     * @param int $level
     * @return string
     */
    private function compress($data, $level = 0)
    {
        if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false)) {
            $encoding = 'gzip';
        }
        if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip') !== false)) {
            $encoding = 'x-gzip';
        }
        if (!isset($encoding) || ($level < -1 || $level > 9)) {
            return $data;
        }
        if (!extension_loaded('zlib') || ini_get('zlib.output_compression')) {
            return $data;
        }
        if (headers_sent()) {
            return $data;
        }
        if (connection_status()) {
            return $data;
        }
        $this->addHeader('Content-Encoding: ' . $encoding);
        return gzencode($data, (int)$level);
    }
    public function output()
    {
        if ($this->output) {
            if ($this->level) {
                $output = $this->compress($this->output, $this->level);
            } else {
                $output = $this->output;
            }
            if (!headers_sent()) {
                foreach ($this->headers as $header) {
                    header($header, true);
                }
            }
            echo $output;
        }
    }
}
