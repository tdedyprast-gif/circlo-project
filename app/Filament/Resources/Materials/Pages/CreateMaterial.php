<?php

namespace App\Filament\Resources\Materials\Pages;

use App\Filament\Resources\Materials\MaterialResource;
use App\Models\Assignment;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;

class CreateMaterial extends CreateRecord
{
    protected static string $resource = MaterialResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['is_required'] ??= true;

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        $material = new ($this->getModel())([
            'course_session_id' => $data['course_session_id'],
            'title' => $data['title'],
            'content_type' => $data['content_type'],
            'content_url' => $data['content_url'] ?? null,
            'body_text' => $data['body_text'] ?? null,
            'is_required' => $data['is_required'] ?? true,
            'order' => $data['order'],
        ]);

        $material->save();

        if (($data['has_assignment'] ?? false) === true) {
            Assignment::create([
                'course_session_id' => $data['course_session_id'],
                'title' => $data['assignment_title'] ?? null,
                'description' => $data['assignment_description'] ?? null,
                'due_date' => $data['due_date'] ?? null,
                'max_score' => $data['max_score'] ?? 100,
                'allow_offline_submission' => $data['allow_offline_submission'] ?? true,
            ]);
        }

        return $material;
    }
}
