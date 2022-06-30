<?php

namespace Rsa97\Zulip;

class UserGroup implements \JsonSerializable
{
    use Parseable;
    use Jsonable;

    #[Parseable('id')]
    public readonly int $id;
    #[Parseable('name', required: true)]
    #[Jsonable('name')]
    public readonly string $name;
    #[Parseable('description', required: true)]
    #[Jsonable('description')]
    public readonly string $description;
    #[Parseable('members')]
    #[Jsonable('members')]
    public readonly array $memberIds;
    #[Parseable('direct_subgroup_ids')]
    public readonly array $subgroupIds;
    #[Parseable('is_system_group')]
    public readonly bool $isSystemGroup;

    public function __construct(string $name, string $description = '')
    {
        $this->name = $name;
        $this->description = $description;
    }

    public function setMemberIds(array $memberIds): self
    {
        $this->memberIds = $memberIds;
        return $this;
    }
}
