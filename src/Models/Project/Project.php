<?php

namespace Atlassian\JiraRest\Models\Project;

use Atlassian\JiraRest\Models\Issue\Issue;
use Atlassian\JiraRest\Models\JiraEloquentModel;

/**
 * Class Project.
 *
 * @property string $name
 */
class Project extends JiraEloquentModel
{

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'key';

    protected $fillable = [
        'id',
        'key',
        'description',
        'lead',
        'components',
        'issueTypes',
        'assigneeType',
        'versions',
        'name',
        'roles',
        'avatarUrls',
        'projectTypeKey',
    ];

    public function issues()
    {
        return $this->hasMany(Issue::class, 'project');
    }

    public function avatar()
    {
        
    }

}
