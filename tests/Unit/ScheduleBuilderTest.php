<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Livewire\Admin\ScheduleBuilder;
use Livewire\Livewire;

class ScheduleBuilderTest extends TestCase
{
    public function test_initial_state()
    {
        $component = new ScheduleBuilder();
        $component->mount();

        $this->assertEquals(1, $component->selectedSection);
        $this->assertNotEmpty($component->scheduleData);
    }

    public function test_get_slot_data_logic()
    {
        $component = new ScheduleBuilder();
        $component->mount();

        // Setup Test Data
        // Section 1 (Target): Monday 08:00 - Science 7 (Mrs. Reyes)
        // Section 2: Monday 10:00 - Math 8 (Mr. Cruz)

        // Case A: Section Busy (Target Section 1)
        $slotA = $component->getSlotData('Monday', '08:00');
        $this->assertEquals('section_busy', $slotA['status']);
        $this->assertStringContainsString('Science 7', $slotA['title']);

        // Case E: Free
        $slotE = $component->getSlotData('Monday', '12:00');
        $this->assertEquals('free', $slotE['status']);

        // Case B: Teacher Busy (Overlay)
        // Select Mr. Cruz as overlay teacher
        $component->selectedTeacher = 'Mr. Cruz';
        // At 10:00 AM Monday, Mr. Cruz is teaching Section 2 (Grade 8)
        $slotB = $component->getSlotData('Monday', '10:00');
        $this->assertEquals('teacher_busy', $slotB['status']);
        $this->assertStringContainsString('Grade 8', $slotB['title']);

        // Case C: Subject Match
        // Select 'Science 7'
        $component->selectedSubject = 'Science 7';
        // Monday 08:00 is Science 7
        $slotC = $component->getSlotData('Monday', '08:00');
        $this->assertEquals('subject_match', $slotC['status']); // Should be green

        // Case D: Conflict
        // Force conflict: Add class to Section 1 at 10:00 AM
        // Section 1 is Busy. Mr. Cruz is ALSO Busy (at 10:00 AM in Section 2).
        $component->scheduleData[1]['Monday'][] = [
            'subject' => 'History 7',
            'teacher' => 'Some Teacher',
            'time_start' => '10:00',
            'time_end' => '11:00',
            'room' => '101'
        ];

        $slotD = $component->getSlotData('Monday', '10:00');
        $this->assertEquals('conflict', $slotD['status']);
    }
}
