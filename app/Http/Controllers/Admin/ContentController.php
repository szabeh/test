<?php

namespace App\Http\Controllers\Admin;

use App\Content;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyContentRequest;
use App\Http\Requests\StoreContentRequest;
use App\Http\Requests\UpdateContentRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ContentController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Content::query()->select('*');

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'content_show';
                $editGate      = 'content_edit';
                $deleteGate    = 'content_delete';
                $crudRoutePart = 'contents';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });
            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('image', function ($row) {
                if (!$row->image) {
                    return '';
                }

                $links = [];

                foreach ($row->image as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank"><img src="' . $media->getUrl('thumb') . '" width="50px" height="50px"></a>';
                }

                return implode(' ', $links);
            });
            $table->editColumn('lid', function ($row) {
                return $row->lid ? $row->lid : "";
            });
            $table->editColumn('rutitr', function ($row) {
                return $row->rutitr ? $row->rutitr : "";
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? Content::STATUS_SELECT[$row->status] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'image']);

            return $table->make(true);
        }

        return view('admin.contents.index');
    }

    public function create()
    {
        abort_unless(\Gate::allows('content_create'), 403);

        return view('admin.contents.create');
    }

    public function store(StoreContentRequest $request)
    {
        abort_unless(\Gate::allows('content_create'), 403);

        $content = Content::create($request->all());

        foreach ($request->input('image', []) as $file) {
            $content->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('image');
        }

        return redirect()->route('admin.contents.index');
    }

    public function edit(Content $content)
    {
        abort_unless(\Gate::allows('content_edit'), 403);

        return view('admin.contents.edit', compact('content'));
    }

    public function update(UpdateContentRequest $request, Content $content)
    {
        abort_unless(\Gate::allows('content_edit'), 403);

        $content->update($request->all());

        if (count($content->image) > 0) {
            foreach ($content->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }

        $media = $content->image->pluck('file_name')->toArray();

        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $content->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.contents.index');
    }

    public function show(Content $content)
    {
        abort_unless(\Gate::allows('content_show'), 403);

        return view('admin.contents.show', compact('content'));
    }

    public function destroy(Content $content)
    {
        abort_unless(\Gate::allows('content_delete'), 403);

        $content->delete();

        return back();
    }

    public function massDestroy(MassDestroyContentRequest $request)
    {
        Content::whereIn('id', request('ids'))->delete();

        return response(null, 204);
    }
}
