<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\AuditStatements\Traits;

trait Keywordable
{
    public $keywords = [];
    public $newKeyword = '';

    public function addKeyword(): void
    {
        if (mb_trim($this->newKeyword) !== '' && ! in_array($this->newKeyword, $this->keywords)) {
            $this->keywords[] = $this->newKeyword;
            $this->newKeyword = '';
        }
    }

    public function removeKeyword($index): void
    {
        unset($this->keywords[$index]);
        $this->keywords = array_values($this->keywords);
    }
}
