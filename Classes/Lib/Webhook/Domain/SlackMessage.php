<?php
namespace JonathanKrusy\Webhook\Domain;

class SlackMessage extends AbstractWebhookMessage {

	/**
	 * @var string
	 */
	protected $url = "";

	/**
	 * @var string
	 */
	protected $username = "";

	/**
	 * @var string
	 */
	protected $icon_emoji = ':warning:';

	/**
	 * @var array
	 */
	protected $attachments = array();

	/**
	 * @var string
	 */
	protected $channel = "";

	/**
	 * @var string
	 */
	protected $link = "";

	/**
	 * @param string $url
	 */
	public function __construct($url) {
		$this->url = $url;
	}

	/**
	 * @return string
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * @param string $username
	 */
	public function setUsername($username)
	{
		$this->username = $username;
	}

	/**
	 * @return string
	 */
	public function getIconEmoji()
	{
		return $this->icon_emoji;
	}

	/**
	 * @param string $icon_emoji
	 */
	public function setIconEmoji($icon_emoji)
	{
		$this->icon_emoji = $icon_emoji;
	}

	/**
	 * @return array
	 */
	public function getAttachments()
	{
		return $this->attachments;
	}

	/**
	 * @param array $attachments
	 */
	public function setAttachments($attachments)
	{
		$this->attachments = $attachments;
	}

	/**
	 * @return string
	 */
	public function getChannel()
	{
		return $this->channel;
	}

	/**
	 * @param string $channel
	 */
	public function setChannel($channel)
	{
		$this->channel = $channel;
	}


	/**
	 * @return string
	 */
	public function getLink()
	{
		return $this->link;
	}

	/**
	 * @param string $link
	 */
	public function setLink($link)
	{
		$this->link = $link;
	}

	/**
	 * @param string $text
	 * @return mixed|void
	 */
	public function send($text = "") {
		$ch = curl_init();

		// set message
		$message = $text != "" ? $text : $this->text;

		// create payload array
		$payloadArray = array(
			"username" => $this->username,
			"icon_emoji" => $this->icon_emoji,
			"text" => $message,
			"attachments" => $this->attachments
		);
		if($this->channel !== "") {
			$payloadArray["channel"] = $this->channel;
		}
		if($this->link != '') {
			$payloadArray["username"] .= " (Web)";;
		}

		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $this->url);
		curl_setopt($ch,CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch,CURLOPT_POSTFIELDS, array(
			"payload" => json_encode($payloadArray)
		));

		//execute post
		curl_exec($ch);

		//close connection
		curl_close($ch);
	}
} 