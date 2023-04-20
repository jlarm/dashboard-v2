<?php

namespace App\Http\Livewire\Dealer\Audit;

use App\Models\Dealer\Audit;
use Livewire\Component;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

class Create extends Component
{
    use WithMedia;

    public $mediaComponentNames = ['osha_q1_images', 'osha_q2_images', 'osha_q3_images'];
    public $draft;
    public $osha_q1_answer;
    public $osha_q1_comment;
    public $osha_q1_images;
    public $osha_q2_answer;
    public $osha_q2_comment;
    public $osha_q2_images;
    public $osha_q3_answer;
    public $osha_q3_comment;
    public $osha_q3_images;

    protected $rules = [
        'draft' => 'nullable',
        'osha_q1_answer' => 'required',
        'osha_q1_comment' => 'nullable',
        'osha_q1_images' => 'nullable',
        'osha_q2_answer' => 'required',
        'osha_q2_comment' => 'nullable',
        'osha_q2_images' => 'nullable',
        'osha_q3_answer' => 'required',
        'osha_q3_comment' => 'nullable',
        'osha_q3_images' => 'nullable',
    ];

    public function submit()
    {
        $this->validate();

        $submission = Audit::create([
            'draft' => 0,
            'osha_q1_answer' => $this->osha_q1_answer,
            'osha_q1_comment' => $this->osha_q1_comment,
            'osha_q2_answer' => $this->osha_q2_answer,
            'osha_q2_comment' => $this->osha_q2_comment,
            'osha_q3_answer' => $this->osha_q3_answer,
            'osha_q3_comment' => $this->osha_q3_comment,
        ]);

        $submission
            ->addFromMediaLibraryRequest($this->osha_q1_images)
            ->toMediaCollection('osha_q1_images');

        $submission
            ->addFromMediaLibraryRequest($this->osha_q2_images)
            ->toMediaCollection('osha_q2_images');

        $submission
            ->addFromMediaLibraryRequest($this->osha_q3_images)
            ->toMediaCollection('osha_q3_images');

        $this->clearMedia();

        $this->reset();
    }

    public function render()
    {
        return view('livewire.dealer.audit.create');
    }
}
