<?php namespace Modules\Filemanager\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file_filemanager' => 'required_without:image_filemanager|mimes:jpeg,jpg,gif,png,bmp,pdf,xls,doc,zip',
            'image_filemanager' => 'required_without:file_filemanager|mimes:jpeg,jpg,gif,png,bmp,pdf,xls,doc,zip',
            'max' => '20000',
        ];
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

    public function messages()
    {
        return [];
    }

}
