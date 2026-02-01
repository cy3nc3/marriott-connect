<?php

namespace App\Livewire\Admin\Scheduling;

use Livewire\Component;

class ScheduleBuilder extends Component
{
    public $sections = [];
    public $subjects = [];
    public $teachers = [];
    public $scheduleData = [];

    // Filters
    public $selectedSection = 1;
    public $selectedTeacher = '';
    public $selectedSubject = '';

    // Modal Control
    public $openModal = false;

    // Form properties
    public $newSchedule = [
        'subject' => '',
        'teacher' => '',
        'days' => [],
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
            'Math 7', 'Science 7', 'English 7', 'Filipino 7', 'History 7', 'MAPEH 7',
            'Math 8', 'Science 8', 'English 8'
        ];

        $this->teachers = [
            'Mr. Cruz', 'Ms. Santos', 'Dr. Garcia', 'Mrs. Reyes'
        ];

        // Default Section
        $this->selectedSection = 1;

        // Mock Existing Schedule
        $this->scheduleData = [
            // Section 1 Schedule
            1 => [
                ['subject' => 'Math 7', 'teacher' => 'Mr. Cruz', 'day' => 'Monday', 'time_start' => '08:00', 'time_end' => '09:00', 'room' => 'Rm 101'],
                ['subject' => 'Science 7', 'teacher' => 'Ms. Santos', 'day' => 'Monday', 'time_start' => '09:00', 'time_end' => '10:00', 'room' => 'Rm 101'],
                ['subject' => 'English 7', 'teacher' => 'Mrs. Reyes', 'day' => 'Tuesday', 'time_start' => '08:00', 'time_end' => '09:00', 'room' => 'Rm 101'],
                // Add more mock data...
            ],
            2 => [] // Empty for now
        ];
    }

    public function openAddModal($day = null, $time = null)
    {
        $this->reset('newSchedule');

        if ($day) {
            $this->newSchedule['days'] = [$day];
        }

        if ($time) {
            // Assume 1 hour slot
            $start = $time; // e.g., '08:00'
            $end = date('H:i', strtotime($start) + 3600);
            $this->newSchedule['time_start'] = $start;
            $this->newSchedule['time_end'] = $end;
        }

        // Pre-fill Subject if filtered (optional logic)
        if ($this->selectedSubject) {
             $this->newSchedule['subject'] = $this->selectedSubject;
        }

        $this->openModal = true;
    }

    public function saveSchedule()
    {
        $this->validate([
            'newSchedule.subject' => 'required',
            'newSchedule.teacher' => 'required',
            'newSchedule.days' => 'required|array|min:1',
            'newSchedule.time_start' => 'required',
            'newSchedule.time_end' => 'required',
        ]);

        // In a real app, we check for conflicts here.

        // Add to schedule data
        if (!isset($this->scheduleData[$this->selectedSection])) {
             $this->scheduleData[$this->selectedSection] = [];
        }

        foreach ($this->newSchedule['days'] as $day) {
            $this->scheduleData[$this->selectedSection][] = [
                'subject' => $this->newSchedule['subject'],
                'teacher' => $this->newSchedule['teacher'],
                'day' => $day,
                'time_start' => $this->newSchedule['time_start'],
                'time_end' => $this->newSchedule['time_end'],
                'room' => $this->newSchedule['room'] ?? 'TBD',
            ];
        }

        $this->openModal = false;
        session()->flash('message', 'Schedule added successfully.');
    }

    public function getSlotData($day, $time)
    {
        $currentSchedule = $this->scheduleData[$this->selectedSection] ?? [];
        $slotStart = strtotime($time);
        $slotEnd = $slotStart + 3600; // 1 Hour Slots

        // Find intersecting class
        foreach ($currentSchedule as $class) {
            if ($class['day'] !== $day) continue;

            $classStart = strtotime($class['time_start']);
            $classEnd = strtotime($class['time_end']);

            // Simple intersection check for 1 hour blocks
            if ($classStart < $slotEnd && $classEnd > $slotStart) {
                // Determine Color
                $classColor = 'bg-green-100 text-green-800 border-green-200'; // Default
                if ($this->selectedTeacher && $class['teacher'] === $this->selectedTeacher) {
                    $classColor = 'bg-orange-100 text-orange-800 border-orange-200';
                }
                if ($this->selectedSubject && $class['subject'] === $this->selectedSubject) {
                    $classColor = 'bg-indigo-100 text-indigo-800 border-indigo-200';
                }

                return [
                    'status' => 'busy',
                    'class' => $classColor . ' border shadow-sm',
                    'title' => $class['subject'],
                    'subtitle' => $class['teacher'] . ' (' . $class['room'] . ')'
                ];
            }
        }

        return [
            'status' => 'free',
            'class' => 'hover:bg-gray-50 cursor-pointer',
            'title' => '',
            'subtitle' => ''
        ];
    }

    public function render()
    {
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $timeSlots = ['07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00'];

        return view('livewire.admin.scheduling.schedule-builder', [
            'currentSchedule' => $this->scheduleData[$this->selectedSection] ?? [],
            'daysOfWeek' => $daysOfWeek,
            'timeSlots' => $timeSlots,
        ])->layout('layouts.app', ['header' => 'Schedule Builder']);
    }
}
