<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class ScheduleBuilder extends Component
{
    public $sections = [];
    public $subjects = [];
    public $teachers = [];
    public $scheduleData = [];

    public $selectedSection;

    // Form properties
    public $newSchedule = [
        'subject' => '',
        'teacher' => '',
        'days' => [], // Array of selected days
        'time_start' => '',
        'time_end' => '',
        'room' => '',
    ];

    public function mount()
    {
        // Mock Data Initialization
        $this->sections = [
            1 => 'Grade 7 - Rizal',
            2 => 'Grade 8 - Bonifacio',
            3 => 'Grade 9 - Luna',
        ];

        $this->subjects = [
            'Math', 'Science', 'English', 'Filipino', 'History', 'MAPEH'
        ];

        $this->teachers = [
            'Mr. Cruz', 'Ms. Santos', 'Dr. Garcia', 'Mrs. Reyes'
        ];

        // Default Section
        $this->selectedSection = 1;

        // Initialize Mock Schedule Data
        // Structure: [section_id => [day => [items]]]
        $this->scheduleData = [
            1 => [ // Grade 7 - Rizal
                'Monday' => [
                    ['subject' => 'Math', 'teacher' => 'Mr. Cruz', 'time_start' => '08:00', 'time_end' => '09:00', 'room' => 'Rm 101'],
                    ['subject' => 'English', 'teacher' => 'Ms. Santos', 'time_start' => '09:00', 'time_end' => '10:00', 'room' => 'Rm 101'],
                ],
                'Wednesday' => [
                    ['subject' => 'Science', 'teacher' => 'Dr. Garcia', 'time_start' => '08:00', 'time_end' => '09:30', 'room' => 'Lab 1'],
                ]
            ],
            2 => [ // Grade 8 - Bonifacio
                'Tuesday' => [
                    ['subject' => 'History', 'teacher' => 'Mrs. Reyes', 'time_start' => '10:00', 'time_end' => '11:00', 'room' => 'Rm 202'],
                ]
            ]
        ];
    }

    public function addSchedule()
    {
        // Simple Validation
        if (empty($this->newSchedule['subject']) || empty($this->newSchedule['days'])) {
            return;
        }

        // Add to scheduleData
        foreach ($this->newSchedule['days'] as $day) {
            // Ensure array structure exists
            if (!isset($this->scheduleData[$this->selectedSection][$day])) {
                $this->scheduleData[$this->selectedSection][$day] = [];
            }

            // Push new item
            $this->scheduleData[$this->selectedSection][$day][] = [
                'subject' => $this->newSchedule['subject'],
                'teacher' => $this->newSchedule['teacher'],
                'time_start' => $this->newSchedule['time_start'],
                'time_end' => $this->newSchedule['time_end'],
                'room' => $this->newSchedule['room'],
            ];

            // Sort by time (optional, but good for UX)
            usort($this->scheduleData[$this->selectedSection][$day], function($a, $b) {
                return strcmp($a['time_start'], $b['time_start']);
            });
        }

        // Reset Form
        $this->newSchedule = [
            'subject' => '',
            'teacher' => '',
            'days' => [],
            'time_start' => '',
            'time_end' => '',
            'room' => '',
        ];

        // Close modal (handled by front-end dispatch or data binding reset)
        $this->dispatch('schedule-added');
        session()->flash('message', 'Schedule added successfully.');
    }

    public function render()
    {
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        // Get current section's schedule or empty array
        $currentSchedule = $this->scheduleData[$this->selectedSection] ?? [];

        return view('livewire.admin.schedule-builder', [
            'daysOfWeek' => $daysOfWeek,
            'currentSchedule' => $currentSchedule
        ]);
    }
}
