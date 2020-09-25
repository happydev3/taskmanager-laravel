<?php

namespace App;

use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use \DateTimeInterface;

class Task extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait, Auditable;

    public $table = 'tasks';

    public static $searchable = [
        'contact_person',
        'name',
    ];

    protected $dates = [
        'due_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [
        'client_file',
        'field_file',
        'dwg_file',
        'final_file',
        'authority_file',
    ];

    const JOB_TYPE_RADIO = [
        'grading'     => 'Grading',
        'legal'       => 'Legal',
        'engineering' => 'Engineering',
        'energy_code' => 'Energy Code',
        'geotech'     => 'Geotech',
    ];

    protected $fillable = [
        'job_type',
        'status_id',
        'applicant_id',
        'optional_email',
        'contact_person',
        'name',
        'lot',
        'block',
        'plan',
        'houseno_unit',
        'street',
        'city_id',
        'subdivision_id',
        'ascm',
        'description',
        'survey_by_id',
        'assigned_to_id',
        'dwg_by_id',
        'due_date',
        'passed',
        'failed',
        'resurveyed',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(50)->height(50);
    }

    public function relatedTaskComments()
    {
        return $this->hasMany(Comment::class, 'related_task_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(TaskStatus::class, 'status_id');
    }

    public function applicant()
    {
        return $this->belongsTo(CrmCustomer::class, 'applicant_id');
    }

    public function city()
    {
        return $this->belongsTo(TaskCity::class, 'city_id');
    }

    public function subdivision()
    {
        return $this->belongsTo(TaskSubdivision::class, 'subdivision_id');
    }

    public function getClientFileAttribute()
    {
        return $this->getMedia('client_file');
    }

    public function getFieldFileAttribute()
    {
        return $this->getMedia('field_file');
    }

    public function getDwgFileAttribute()
    {
        return $this->getMedia('dwg_file');
    }

    public function getFinalFileAttribute()
    {
        return $this->getMedia('final_file');
    }

    public function getAuthorityFileAttribute()
    {
        return $this->getMedia('authority_file');
    }

    public function tags()
    {
        return $this->belongsToMany(TaskTag::class);
    }

    public function survey_by()
    {
        return $this->belongsTo(User::class, 'survey_by_id');
    }

    public function assigned_to()
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }

    public function dwg_by()
    {
        return $this->belongsTo(User::class, 'dwg_by_id');
    }

    public function getDueDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDueDateAttribute($value)
    {
        $this->attributes['due_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }
}
