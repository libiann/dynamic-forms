<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dynamic Forms</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Styles -->
    <style>
        /* Global Styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Figtree', sans-serif;
            font-size: 16px;
        }

        header {
            background: #f8f8f8;
            padding: 1rem;
            text-align: center;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        main {
            flex: 1;
            padding: 17rem 1rem 1rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        form {
            width: 100%;
            max-width: 600px;
            background: white;
            padding: 2rem;
            border-radius: 10px;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e5e7eb;
            border-radius: 5px;
            font-size: 1rem;
        }
    </style>
</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">

                <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                    <div class="flex lg:justify-center lg:col-start-2">
                        <h1>Dynamic Forms</h1>

                    </div>
                    @if (Route::has('login'))
                        <nav class="-mx-3 flex flex-1 justify-end">
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                    Log in
                                </a>
                            @endauth
                        </nav>
                    @endif
                </header>

                <main class="mt-6">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Whoops!</strong> There were some problems with your input.<br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (isset($formFields) && !empty($formFields))
                        <form action="{{ route('form.store') }}" method="POST">
                            @if (session()->has('success'))
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                </div>
                            @endif
                            @csrf
                            <div class="row">
                                @foreach ($formFields as $field)
                                    @if ($field->type == 'text' || $field->type == 'number')
                                        <div class="col-md-8 mb-4">
                                            <div class="form-group">
                                                <label for={{ $field->label }}> {{ $field->label }} <span
                                                        class="text-danger">*</span>:</label>
                                                <input type={{ $field->type }} name={{ $field->label }}
                                                    id={{ $field->label }} placeholder={{ $field->label }}
                                                    class="form-control" value="{{ old('label') }}" required>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-md-8 mb-4">
                                            <div class="form-group">
                                                <label for={{ $field->label }}>{{ $field->label }} <span
                                                        class="text-danger">*</span>:</label>
                                                <select name={{ $field->label }} class="form-control" required>
                                                    <option value="">Select a {{ $field->label }}</option>
                                                    @if ($field->type == 'select')
                                                        @foreach (json_decode($field->options) as $option)
                                                            <option value={{ $option }}>{{ $option }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-outline btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    @else
                        <p>Project for managing dynamic form</p>
                    @endif
                </main>

                <footer class="py-16 text-center text-sm text-black dark:text-white/70">

                </footer>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>
