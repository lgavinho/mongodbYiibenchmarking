<?php

class Event extends EMongoDocument {

	public $eventId;
	public $eventTitle;
	public $eventDescription;
	public $planner;
	public $venues;
	public $ticketType;

	/**
     * This method have to be defined in every Model
     * @return string MongoDB collection name, witch will be used to store documents of this model
     */
	public function getCollectionName() {
		return 'event';
	}

	 // We can define rules for fields, just like in normal CModel/CActiveRecord classes
    public function rules() {
        return array(
            array('id, title, description', 'required'),
            array('id', 'numeric', 'integerOnly' => true),
        );
    }

    /**
     * This method have to be defined in every model, like with normal CActiveRecord
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }	

}