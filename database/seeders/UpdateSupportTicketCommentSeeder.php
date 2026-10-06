<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SupportTicketComment;

class UpdateSupportTicketCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update support_ticket_comments record with id 332
        $comment = SupportTicketComment::find(333);

        if ($comment) {
            $comment->update([
                'user_id' => 6,
                'commented_by' => 'staff',
            ]);

            $this->command->info('Support ticket comment ID 332 updated successfully.');
        } else {
            $this->command->error('Support ticket comment with ID 332 not found.');
        }
    }
}
