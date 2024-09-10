@extends('admin/layouts/head-main')

@section('content')

<title>Library Documents</title>

<div class="page-wrapper">

    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Documents for {{ $library->airline->airline_name }}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.library') }}">Library</a></li>
                        <li class="breadcrumb-item active">Documents</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">

                            @foreach($library->documents as $document)
                              <div class="col-md-3">
    @php
        $fileExtension = pathinfo($document->file_path, PATHINFO_EXTENSION);
    @endphp
    @if(in_array($fileExtension, ['jpg', 'jpeg', 'png']))
        <img src="{{ asset($document->file_path) }}" alt="Preview" style="max-width: 100px; max-height: 100px;">
    @elseif($fileExtension === 'pdf')


    <iframe src="{{ asset($document->file_path) }}" style="width: 100%; height: 300px;overflow: hidden;" frameborder="0"></iframe>

    @else
        No preview available
    @endif

    <a href="{{ asset($document->file_path) }}" target="_blank" class="btn btn-primary btn-sm">View</a>
</div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
