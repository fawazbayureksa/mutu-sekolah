<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AssessmentAnswer;
use Illuminate\Support\Facades\DB;

class MigrateExistingAnswers extends Command
{
    protected $signature = 'answers:migrate';
    protected $description = 'Migrate existing answers to new structure with type-specific fields';

    public function handle()
    {
        $this->info('Migrating existing answers to new structure...');

        $count = DB::transaction(function () {
            $migrated = 0;

            AssessmentAnswer::with('question')
                ->whereNotNull('answer_value')
                ->where(function ($query) {
                    $query->whereNull('numeric_value')
                        ->orWhereNull('boolean_value');
                })
                ->chunk(100, function ($answers) use (&$migrated) {
                    foreach ($answers as $answer) {
                        $this->migrateAnswer($answer);
                        $migrated++;
                    }

                    if ($migrated % 100 === 0) {
                        $this->line("Migrated {$migrated} answers...");
                    }
                });

            return $migrated;
        });

        $this->info("Migration completed! Total answers migrated: {$count}");
    }

    protected function migrateAnswer($answer)
    {
        $question = $answer->question;

        if (!$question) {
            return;
        }

        $data = [];

        switch ($question->answer_type) {
            case 'boolean':
            case 'option':
                $data['boolean_value'] = $this->parseBoolean($answer->answer_value);
                $data['numeric_value'] = null;
                break;

            case 'scale':
            case 'number':
                $data['numeric_value'] = (float) $answer->answer_value;
                $data['boolean_value'] = null;
                break;

            case 'percentage':
                $data['numeric_value'] = (float) $answer->answer_value;
                $data['boolean_value'] = null;
                break;

            case 'multiple_choice':
                $options = $question->getAnswerOptionsArray();
                if ($options) {
                    $option = collect($options)->firstWhere('value', $answer->answer_value);
                    if ($option && isset($option['score'])) {
                        $data['numeric_value'] = (float) $option['score'];
                        $data['boolean_value'] = null;
                    }
                }
                break;

            default:
                $data['numeric_value'] = null;
                $data['boolean_value'] = null;
        }

        if (!empty($data)) {
            $answer->update($data);
        }
    }

    protected function parseBoolean($value): ?bool
    {
        if (is_bool($value)) {
            return $value;
        }

        if (is_numeric($value)) {
            return (bool) $value;
        }

        if (is_string($value)) {
            $lower = strtolower($value);
            if (in_array($lower, ['yes', 'ya', 'true', '1', 'y'])) {
                return true;
            }
            if (in_array($lower, ['no', 'tidak', 'false', '0', 'n'])) {
                return false;
            }
        }

        return null;
    }
}
