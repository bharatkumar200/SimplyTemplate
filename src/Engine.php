<?php

namespace SimplyDi\SimplyTemplate;

use Exception;

class Engine
{
    public function __construct(
        private string $templatesDir,
        private string $templatesExtension
    ) {
    }

    private function esc(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    public function render(string $template, array $data = []): string
    {
        $file = $this->templatesDir . DIRECTORY_SEPARATOR . $template . '.' . $this->templatesExtension;

        if (!file_exists($this->templatesDir) || !is_dir($this->templatesDir)) {
            throw new Exception("Templates directory does not exist: {$this->templatesDir}");
        }

        if (!file_exists($file)) {
            throw new Exception("No such template exists: {$file}");
        }

        extract($data);

        ob_start();
        include $file;
        $content = ob_get_clean();

        // Check if the template extends another template
        if (preg_match('/@extend=(\w+)/', $content, $matches)) {
            $parentTemplate = trim($matches[1]) . '.' . $this->templatesExtension;
            $parentFile = $this->templatesDir . DIRECTORY_SEPARATOR . $parentTemplate;

            if (file_exists($parentFile)) {
                ob_start();
                include $parentFile;
                $content = ob_get_clean();
            }

            // Remove template control codes from the content
            $content = preg_replace('/@extend=\w+/', '', $content);
        }

        return $content;
    }

}
