<?php
namespace App\Actions\Group;

use App\Repositories\GroupRepository;
use App\Repositories\GroupRepositoryInterface;

class CreateGroupAction
{
    protected $groupRepository;

    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    public function execute(array $data)
    {
        //    بدي ياها مشان ارسل اشعار للادمن بانشاء مجموعة
        return $this->groupRepository->createGroup($data);
        
    }
}
