<?php

namespace App\Livewire\Admin;

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

        // Initialize Mock Schedule Data
        // Structure: [section_id => [day => [items]]]
        $this->scheduleData = [
            1 => [ // Grade 7 - Rizal
                'Monday' => [
                    ['subject' => 'Science 7', 'teacher' => 'Mrs. Reyes', 'time_start' => '08:00', 'time_end' => '09:00', 'room' => 'Rm 101'],
                ],
            ],
            2 => [ // Grade 8 - Bonifacio
                'Monday' => [
                     // Case B trigger: Mr. Cruz teaching Grade 8 at 10:00 AM
                    ['subject' => 'Math 8', 'teacher' => 'Mr. Cruz', 'time_start' => '10:00', 'time_end' => '11:00', 'room' => 'Rm 202'],
                ],
                'Wednesday' => [ // Just some extra data
                    ['subject' => 'Science 8', 'teacher' => 'Dr. Garcia', 'time_start' => '08:00', 'time_end' => '09:00', 'room' => 'Lab 1'],
                ]
            ]
        ];
    }

    public function openAddModal($day, $timeStart)
    {
        // Pre-fill logic
        $this->newSchedule = [
            'subject' => $this->selectedSubject, // Pre-fill if filter active
            'teacher' => $this->selectedTeacher, // Pre-fill if filter active
            'days' => [$day],
            'time_start' => $timeStart,
            'time_end' => date('H:i', strtotime($timeStart) + 3600), // +1 Hour default
            'room' => '',
        ];

        $this->openModal = true;
    }

    public function addSchedule()
    {
        $this->validate([
            'newSchedule.subject' => 'required',
            'newSchedule.teacher' => 'required',
            'newSchedule.days' => 'required|array',
            'newSchedule.time_start' => 'required',
            'newSchedule.time_end' => 'required',
        ]);

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

            // Sort by time
            usort($this->scheduleData[$this->selectedSection][$day], function($a, $b) {
                return strcmp($a['time_start'], $b['time_start']);
            });
        }

        $this->openModal = false;
        session()->flash('message', 'Class added successfully.');
    }

    // Helper for View
    public function getSlotData($day, $timeStart)
    {
        // Define Time End for this slot (1 hour block)
        $timeEnd = date('H:i', strtotime($timeStart) + 3600);

        // 1. Check if Target Section is Busy
        $sectionBusy = null;
        if (isset($this->scheduleData[$this->selectedSection][$day])) {
            foreach ($this->scheduleData[$this->selectedSection][$day] as $class) {
                // Check overlap
                if ($this->isOverlap($timeStart, $timeEnd, $class['time_start'], $class['time_end'])) {
                    $sectionBusy = $class;
                    break;
                }
            }
        }

        // 2. Check if Selected Teacher is Busy (in other sections)
        $teacherBusy = null;
        if ($this->selectedTeacher) {
            foreach ($this->scheduleData as $secId => $days) {
                if ($secId == $this->selectedSection) continue;

                if (isset($days[$day])) {
                    foreach ($days[$day] as $class) {
                        if ($class['teacher'] === $this->selectedTeacher) {
                            if ($this->isOverlap($timeStart, $timeEnd, $class['time_start'], $class['time_end'])) {
                                $teacherBusy = $class;
                                $teacherBusy['section_name'] = $this->sections[$secId];
                                break 2;
                            }
                        }
                    }
                }
            }
        }

        // 3. Determine Status

        // Case D: Double Conflict
        if ($sectionBusy && $teacherBusy) {
            return [
                'status' => 'conflict',
                'bg' => 'bg-red-500',
                'text_color' => 'text-white',
                'title' => 'Double Conflict',
                'subtitle' => 'Section & Teacher Busy'
            ];
        }

        // Case A or C: Section Busy
        if ($sectionBusy) {
            // Case C: Subject Match
            if ($this->selectedSubject && $sectionBusy['subject'] === $this->selectedSubject) {
                return [
                    'status' => 'subject_match',
                    'bg' => 'bg-green-500',
                    'text_color' => 'text-white',
                    'title' => $sectionBusy['subject'],
                    'subtitle' => $sectionBusy['teacher']
                ];
            }

            // Case A: Standard Section Busy
            return [
                'status' => 'section_busy',
                'bg' => 'bg-blue-500',
                'text_color' => 'text-white',
                'title' => $sectionBusy['subject'] . ' (' . $sectionBusy['teacher'] . ')',
                'subtitle' => ''
            ];
        }

        // Case B: Teacher Busy
        if ($teacherBusy) {
            return [
                'status' => 'teacher_busy',
                'bg' => 'bg-orange-400',
                'text_color' => 'text-white',
                'title' => 'Teacher Busy: ' . $teacherBusy['section_name'],
                'subtitle' => ''
            ];
        }

        // Case E: Free
        return [
            'status' => 'free',
            'bg' => 'bg-white hover:bg-gray-50 cursor-pointer',
            'text_color' => 'text-gray-400',
            'title' => '+',
            'subtitle' => ''
        ];
    }

    private function isOverlap($start1, $end1, $start2, $end2)
    {
        // Simple string comparison for HH:MM works well
        return ($start1 < $end2) && ($end1 > $start2);
    }

    public function render()
    {
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $timeSlots = [];
        $start = strtotime('07:00');
        $end = strtotime('16:00'); // 4:00 PM

        while ($start < $end) {
            $timeSlots[] = date('H:i', $start);
            $start += 3600; // +1 hour
        }

        return view('livewire.admin.schedule-builder', [
            'daysOfWeek' => $daysOfWeek,
            'timeSlots' => $timeSlots
        ]);
    }
}
