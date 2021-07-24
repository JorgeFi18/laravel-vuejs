<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        foreach ($plans as $plan) {
            $plan->includes = explode(",", $plan->includes);
        }
        return $plans;
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $plan = new Plan;
        $plan->name = $request->input('name');
        $plan->price = $request->input('price');
        $plan->includes = $request->input('includes');

        $plan->save();

        return $plan;
    }

    public function show($id)
    {
        return Plan::findOrFail($id)->get();
    }

    public function update(Request $request, $id)
    {
        $plan = Plan::findOrFail($id);
        $plan->update($request->all());

        return $plan;
    }

    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();

        return $plan;
    }
}
