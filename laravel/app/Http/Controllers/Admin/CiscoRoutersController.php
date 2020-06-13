<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CiscoRouter\BulkDestroyCiscoRouter;
use App\Http\Requests\Admin\CiscoRouter\DestroyCiscoRouter;
use App\Http\Requests\Admin\CiscoRouter\IndexCiscoRouter;
use App\Http\Requests\Admin\CiscoRouter\StoreCiscoRouter;
use App\Http\Requests\Admin\CiscoRouter\UpdateCiscoRouter;
use App\Models\CiscoRouter;
use Brackets\AdminListing\Facades\AdminListing;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CiscoRoutersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexCiscoRouter $request
     * @return array|Factory|View
     */
    public function index(IndexCiscoRouter $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(CiscoRouter::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'sapId', 'hostname', 'loopback', 'mac_address'],

            // set columns to searchIn
            ['id', 'sapId', 'hostname', 'loopback', 'mac_address']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.cisco-router.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.cisco-router.create');

        return view('admin.cisco-router.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCiscoRouter $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreCiscoRouter $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the CiscoRouter
        $ciscoRouter = CiscoRouter::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/cisco-routers'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/cisco-routers');
    }

    /**
     * Display the specified resource.
     *
     * @param CiscoRouter $ciscoRouter
     * @throws AuthorizationException
     * @return void
     */
    public function show(CiscoRouter $ciscoRouter)
    {
        $this->authorize('admin.cisco-router.show', $ciscoRouter);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CiscoRouter $ciscoRouter
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(CiscoRouter $ciscoRouter)
    {
        $this->authorize('admin.cisco-router.edit', $ciscoRouter);


        return view('admin.cisco-router.edit', [
            'ciscoRouter' => $ciscoRouter,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCiscoRouter $request
     * @param CiscoRouter $ciscoRouter
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateCiscoRouter $request, CiscoRouter $ciscoRouter)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values CiscoRouter
        $ciscoRouter->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/cisco-routers'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/cisco-routers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyCiscoRouter $request
     * @param CiscoRouter $ciscoRouter
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyCiscoRouter $request, CiscoRouter $ciscoRouter)
    {
        $ciscoRouter->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyCiscoRouter $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyCiscoRouter $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    DB::table('ciscoRouters')->whereIn('id', $bulkChunk)
                        ->update([
                            'deleted_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
