<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecordRequest;
use App\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecordController extends Controller
{
    public function index()
    {
        $records = $this->takeRecord()->paginate(2);
        return view('records.list', ['records' => $records]);
    }

    public function create()
    {
        return view('records.create');
    }

    public function store(RecordRequest $request)
    {
        $attributes = $request->validated();

        $attributes['user_id'] = auth()->id();

        if (request('image')) {
            $attributes['image'] = request('image')->store('uploads');
        }

        Record::create($attributes);

        return redirect()->route('records.index')
            ->with('success', __('record.create'));
    }

    public function show($id)
    {
        $record = $this->takeRecord()->findOrFail($id);
        return view('records.show', ['record' => $record]);
    }

    public function edit($id)
    {
        $record = $this->takeRecord()->findOrFail($id);
        return view('records.edit', ['record' => $record]);
    }

    public function update(RecordRequest $request, Record $record)
    {
        $attributes = $request->validated();

        $attributes['user_id'] = auth()->id();

        if (request('image')) {
            $attributes['image'] = request('image')->store('uploads');
        }

        $record->update($attributes);

        return redirect()->route('records.index')
            ->with('success', __('record.update'));
    }

    public function destroy($id)
    {
        $this->takeRecord()->findOrFail($id)->delete();
        return redirect()->route('records.index')
            ->with('success', __('record.destroy'));
    }

    //  === Под вопросом, требует консультации
    public function takeRecord()
    {
        return Auth::user()->records();
    }


}
