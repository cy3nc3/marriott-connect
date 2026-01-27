<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Carbon\Carbon;

class ClassListReport extends Component
{
    public $selectedSection = 1;
    public $sections = [];
    public $classData = [];

    public function mount()
    {
        // Mock Sections
        $this->sections = [
            1 => 'Grade 7 - Rizal',
            2 => 'Grade 8 - Bonifacio',
            3 => 'Grade 10 - Mabini',
        ];

        // Mock Class Data (Adviser, Boys, Girls)
        $this->classData = [
            1 => [ // Grade 7 - Rizal
                'adviser' => 'Mr. Juan Cruz',
                'boys' => [
                    'Abad, Anthony',
                    'Bautista, Ben',
                    'Castro, Charles',
                    'Dela Cruz, Daniel',
                    'Estrada, Emilio',
                    'Ferrer, Francis',
                    'Gomez, Gabriel',
                    'Hernandez, Hector',
                ],
                'girls' => [
                    'Alonzo, Bea',
                    'Bernardo, Kathryn',
                    'Curtis, Anne',
                    'Dantes, Marian',
                    'Evangelista, Heart',
                    'Forteza, Barbie',
                    'Geronimo, Sarah',
                    'Hermosa, Kristine',
                ]
            ],
            2 => [ // Grade 8 - Bonifacio
                'adviser' => 'Ms. Maria Santos',
                'boys' => [
                    'Ignacio, Ivan',
                    'Javier, Jose',
                    'Kalaw, Kevin',
                    'Lopez, Luis',
                    'Manalo, Mark',
                ],
                'girls' => [
                    'Imperial, Iza',
                    'Jimenez, Jessy',
                    'Kasilag, Karla',
                    'Lim, Liza',
                    'Mendiola, Maine',
                ]
            ],
            3 => [ // Grade 10 - Mabini
                'adviser' => 'Dr. Jose Garcia',
                'boys' => [
                    'Navarro, Nathan',
                    'Ocampo, Oscar',
                    'Perez, Patrick',
                    'Quizon, Quintin',
                ],
                'girls' => [
                    'Nadal, Nina',
                    'Oineza, Olivia',
                    'Padilla, Pia',
                    'Quinto, Queenie',
                ]
            ],
        ];
    }

    public function render()
    {
        $currentClass = $this->classData[$this->selectedSection] ?? $this->classData[1];
        $currentSectionName = $this->sections[$this->selectedSection] ?? 'Unknown Section';
        $dateGenerated = Carbon::now()->format('F j, Y');

        return view('livewire.admin.class-list-report', [
            'currentClass' => $currentClass,
            'currentSectionName' => $currentSectionName,
            'dateGenerated' => $dateGenerated,
        ]);
    }
}
