<?php

namespace App\Http\Controllers\Api\Frotas;

use App\Http\Requests\Frotas\StoreUpdateVisitors;
use App\Models\Visitor;
use App\Http\Controllers\Controller;
use App\Http\Resources\VisitorResource;
use App\Services\TableService;
use Illuminate\Http\Request;

class VisitorsApiController extends Controller
{
    public function __construct(protected TableService $tableService)
    {
    }

    public function all()
    {
        return VisitorResource::collection($this->tableService->getTableVisitor(new Visitor()));
    }

    public function updateStatus(Request $request, $visitorId)
    {
        if (!$request->input('status')) {
            return response()->json('Status not define', 404);
        }

        if (!$visitor = Visitor::where('id', $visitorId)->first()) {
            return response()->json('Object Visitor not found in scope', 404);
        }

        $visitor->status = $request->input('status');
        $visitor->save();

        return new VisitorResource($visitor);
    }
}
