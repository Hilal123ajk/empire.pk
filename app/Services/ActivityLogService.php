<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogService
{
    public function log(
        string $action,
        string $subjectType,
        ?int $subjectId,
        string $subjectLabel,
        ?string $description = null,
        ?array $properties = null,
    ): ActivityLog {
        $user = Auth::user();

        return ActivityLog::query()->create([
            'user_id' => $user?->id,
            'user_name' => $user?->name ?? 'System',
            'action' => $action,
            'subject_type' => $subjectType,
            'subject_id' => $subjectId,
            'subject_label' => $subjectLabel,
            'description' => $description ?? $this->buildDescription($action, $subjectType, $subjectLabel, $user?->name ?? 'System', $properties),
            'properties' => $properties,
        ]);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getRecentForDashboard(int $limit = 20): array
    {
        return ActivityLog::query()
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get()
            ->map(fn (ActivityLog $log) => [
                'id' => $log->id,
                'action' => $log->action,
                'subject_type' => $log->subject_type,
                'description' => $log->description,
                'user' => $log->user_name,
                'created_at' => $log->created_at?->format('M j, Y g:i A') ?? '',
                'created_at_human' => $log->created_at?->diffForHumans() ?? '',
            ])
            ->all();
    }

    /**
     * @param  array<string, mixed>|null  $properties
     */
    private function buildDescription(
        string $action,
        string $subjectType,
        string $subjectLabel,
        string $userName,
        ?array $properties,
    ): string {
        $subject = ucfirst($subjectType);

        return match ($action) {
            'created' => "{$userName} created {$subjectType} \"{$subjectLabel}\"",
            'updated' => "{$userName} updated {$subjectType} \"{$subjectLabel}\"",
            'deleted' => "{$userName} moved {$subjectType} \"{$subjectLabel}\" to trash",
            'restored' => "{$userName} restored {$subjectType} \"{$subjectLabel}\"",
            'force_deleted' => "{$userName} permanently deleted {$subjectType} \"{$subjectLabel}\"",
            'status_changed' => $this->statusChangedDescription($userName, $subjectLabel, $properties),
            default => "{$userName} performed {$action} on {$subjectType} \"{$subjectLabel}\"",
        };
    }

    /**
     * @param  array<string, mixed>|null  $properties
     */
    private function statusChangedDescription(string $userName, string $subjectLabel, ?array $properties): string
    {
        $from = $properties['from_status'] ?? 'unknown';
        $to = $properties['to_status'] ?? 'unknown';

        return "{$userName} changed order {$subjectLabel} status from {$from} to {$to}";
    }
}
