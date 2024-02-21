<?php

namespace App\Http\Livewire\Central\AuditStatements\Traits;

trait Keywordable
{
    public $keywords = [];

    public $newKeyword = '';

    public function addKeyword()
    {
        if (trim($this->newKeyword) !== '' && ! in_array($this->newKeyword, $this->keywords)) {
            $this->keywords[] = $this->newKeyword;
            $this->newKeyword = '';
        }
    }

    public function removeKeyword($index)
    {
        unset($this->keywords[$index]);
        $this->keywords = array_values($this->keywords);
    }
}
