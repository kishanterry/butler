<?php namespace Butler\Http\Requests;

use Illuminate\Auth\Guard;

class CreateAppRequest extends Request
{
    /**
     * @var Guard
     */
    private $auth;

    /**
     * @param Guard $auth
     */
    function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }


	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		if($this->auth->guest()) {
			return false;
		}

		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'name' => 'required|unique:apps'
		];
	}

}
