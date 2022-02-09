<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
{
    protected $user;

    public function __construct(User $user, array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->user = $user;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'upload_photos' => 'nullable|array',
            'upload_photos.*' => 'required|string',
            'name' => 'required|string',
            'last_name' => 'required|string',
            'dni' => 'required|string',
            'email' => 'required|email|unique:users,email,'. $this->user->id .',id,deleted_at,NULL',
            'password' => 'nullable|confirmed',
            'active' => 'required|boolean',
        ];
    }
}
