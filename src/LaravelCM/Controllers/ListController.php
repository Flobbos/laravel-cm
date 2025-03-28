<?php

namespace Flobbos\LaravelCM\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Flobbos\LaravelCM\Contracts\ListContract;
use Exception;

class ListController extends Controller
{

    protected $lists;

    public function __construct(ListContract $lists)
    {
        $this->lists = $lists;
    }

    //Lists
    public function index()
    {
        return view('laravel-cm::lists.index')->withLists($this->lists->get());
    }

    public function showListDetails($list_id)
    {
        try {
            $list_details = $this->lists->details($list_id);
            return view('laravel-cm::lists.show')->withList($list_details);
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }

    public function showListStats($list_id)
    {
        try {
            $list = $this->lists->stats($list_id);
            return view('laravel-cm::lists.stats')->withList($list)->with('list_id', $list_id);
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }

    public function create()
    {
        return view('laravel-cm::lists.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Title' => 'required',
        ]);
        try {
            $result = $this->lists->create($request->except('_token'));
            return redirect()->route('laravel-cm::lists.index')->withMessage(trans('laravel-cm::crud.record_created') . ' ID: ' . $result);
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage())->withInput();
        }
    }

    public function edit($list_id)
    {
        try {
            $list = $this->lists->details($list_id);
            return view('laravel-cm::lists.edit')->with('list', $list);
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }

    public function update(Request $request, $list_id)
    {
        try {
            $this->lists->update($list_id, $request->except('_token'));
            return redirect()->route('laravel-cm::lists.index')->withMessage(trans('laravel-cm::crud.record_updated'));
        } catch (Exception $ex) {
            return redirect()->back()->withInput()->withErrors($ex->getMessage());
        }
    }

    public function destroy($list_id)
    {
        try {
            $this->lists->delete($list_id);
            return redirect()->back()->withMessage(trans('laravel-cm::crud.delete_success', ['list_id' => $list_id]));
        } catch (Exception $ex) {
            return redirect()->back()->withMessage(trans('laravel-cm::crud.delete_error', ['list_id' => $list_id]));
        }
    }
}
