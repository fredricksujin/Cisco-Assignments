<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Router\BulkDestroyRouter;
use App\Http\Requests\Admin\Router\DestroyRouter;
use App\Http\Requests\Admin\Router\IndexRouter;
use App\Http\Requests\Admin\Router\StoreRouter;
use App\Http\Requests\Admin\Router\UpdateRouter;
use App\Models\Router;
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

class RoutersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexRouter $request
     * @return array|Factory|View
     */
    public function index(IndexRouter $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Router::class)->processRequestAndGet(
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

        return view('admin.router.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.router.create');

        return view('admin.router.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRouter $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreRouter $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Router
        $router = Router::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/routers'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/routers');
    }

    /**
     * Display the specified resource.
     *
     * @param Router $router
     * @throws AuthorizationException
     * @return void
     */
    public function show(Router $router)
    {
        $this->authorize('admin.router.show', $router);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Router $router
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Router $router)
    {
        $this->authorize('admin.router.edit', $router);


        return view('admin.router.edit', [
            'router' => $router,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRouter $request
     * @param Router $router
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateRouter $request, Router $router)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Router
        $router->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/routers'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/routers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyRouter $request
     * @param Router $router
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyRouter $request, Router $router)
    {
        $router->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyRouter $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyRouter $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    DB::table('routers')->whereIn('id', $bulkChunk)
                        ->update([
                            'deleted_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
