<?php namespace Atrakeur\Forum\Repositories;

use \Atrakeur\Forum\Models\ForumMessage;

class MessagesRepository extends AbstractBaseRepository {

	public function __construct(ForumMessage $model)
	{
		$this->model = $model;
	}

	public function getByTopic($topicId, array $with = array())
	{
		if (!is_numeric($topicId))
		{
			throw new \InvalidArgumentException();
		}

		return $this->getManyBy('parent_topic', $topicId);
	}

	public function getLastByTopic($topicId, array $with = array())
	{
		if (!is_numeric($topicId))
		{
			throw new \InvalidArgumentException();
		}

		$model = $this->model->where('parent_topic', '=', $topicId);
		$model = $model->orderBy('created_at', 'DESC')->take(10);
		return $this->model->convertToObject($model->get());
	}

}
