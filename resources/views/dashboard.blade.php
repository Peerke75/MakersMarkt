@extends('layouts.app')

@section('content')
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="flex justify-center p-6 text-gray-900">
                @php
                $hour = date('H');
                $userName = Auth::user()->name;
                if ($hour < 12) {
                    $greeting=__('Goedemorgen, :name!', ['name'=> $userName]);
                    } elseif ($hour < 18) {
                        $greeting=__('Goedemiddag, :name!', ['name'=> $userName]);
                        } elseif ($hour < 22) {
                            $greeting=__('Goedeavond, :name!', ['name'=> $userName]);
                            } else {
                            $greeting = __('Goedenacht, :name!', ['name' => $userName]);
                            }
                            @endphp
                            {{ $greeting }}
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
            <div class="flex justify-center p-6 text-gray-900">
                <p>
                    {{ __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur auctor, orci ac mollis feugiat, eros sapien aliquet elit, sit amet volutpat dui libero eu purus. Integer convallis urna sed justo dignissim, id volutpat lacus ultricies. Aenean cursus mi orci, sed lacinia odio tempor eget. Curabitur finibus, metus ac sollicitudin tempor, eros eros venenatis metus, sit amet cursus urna odio vel nunc. Integer ut enim vel velit pharetra viverra ac nec lectus. Nullam viverra sapien eu sem interdum, id euismod metus ullamcorper. Donec eleifend convallis tellus, non tristique magna efficitur ac. Integer gravida dui ac ipsum dapibus, sit amet feugiat arcu vulputate. Mauris gravida sapien non turpis auctor vehicula.

                          Etiam et metus tristique, euismod urna ac, tincidunt leo. Vivamus euismod mollis odio, eget maximus arcu placerat at. Sed laoreet placerat risus, non convallis nunc dictum ac. Aliquam erat volutpat. Fusce varius volutpat enim ac volutpat. Ut sit amet dui aliquam, hendrerit neque a, pretium magna. Vivamus sit amet turpis vel nisl auctor volutpat sed vel libero. Aenean nec leo ut arcu lobortis volutpat vel vitae nunc. Suspendisse vehicula, turpis in consequat fermentum, lorem neque ullamcorper elit, a feugiat mi odio nec sapien. Proin malesuada velit nec tincidunt viverra. Etiam dapibus eros et suscipit laoreet.

                          Nam sed nisi ac sem pretium feugiat. Vivamus faucibus euismod sapien, eget viverra eros faucibus ut. Sed in bibendum eros. Donec vel orci et dolor vestibulum volutpat id in erat. Proin varius mollis purus id congue. Fusce ac sollicitudin eros. Donec eget vestibulum magna, eget mollis ante. In eget purus eu sapien tempor tincidunt sit amet nec elit. Nam vulputate leo non odio consequat lobortis. Curabitur fermentum varius risus et sollicitudin.

                          Nulla vehicula, neque vel euismod gravida, ante felis posuere purus, vitae cursus sapien nisi vitae sem. Curabitur ullamcorper neque nec velit convallis, et elementum turpis pretium. Suspendisse facilisis ante quis velit tempor pharetra. Nam sed laoreet nulla. Sed at tortor fringilla, aliquet ante non, dapibus mauris. Donec vestibulum ipsum a tortor pellentesque, vitae volutpat nulla euismod. Vivamus ac malesuada libero, ac cursus odio. Donec gravida tincidunt mollis. Nulla cursus vitae urna ut laoreet. Proin tempus sapien id massa consectetur, ac aliquam metus aliquet.

                          d condimentum turpis at risus fermentum, at convallis metus viverra. Curabitur vehicula odio et arcu tincidunt, eu pharetra metus dictum. Etiam vel lectus non felis tincidunt varius. Nam ut lectus ac neque ultricies aliquet. Suspendisse at mauris vel est cursus laoreet. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Cras aliquet auctor ligula sit amet interdum. Aliquam sagittis ex id magna interdum, et euismod neque consequat. Nam aliquam libero ligula, eget efficitur sapien pretium eu.

                          In sollicitudin fringilla tortor. Quisque euismod lorem non sapien auctor tincidunt. Phasellus tincidunt nisi sed arcu volutpat, at euismod metus consectetur. Cras et dolor nec dui iaculis porttitor. Sed vulputate augue in felis lobortis, sed scelerisque odio dictum. Nam volutpat, libero et varius facilisis, purus lorem euismod orci, vel vulputate odio nunc in leo. Etiam malesuada risus at ipsum cursus convallis. Nam et risus vestibulum, auctor lorem ut, tincidunt mi. Mauris porttitor turpis sapien, vitae ultricies justo lacinia ac.

                          Ut ultricies euismod augue vel hendrerit. Integer quis velit ac ante consequat dictum sed ut purus. Mauris vitae metus et eros vulputate facilisis. Integer interdum vehicula dui, sed interdum ligula luctus vitae. Quisque euismod ligula eu nisi aliquam pretium. Nunc suscipit ante sed nulla ullamcorper, eu iaculis sem suscipit. Suspendisse viverra lorem et nunc bibendum varius. Aliquam ultricies purus id risus placerat, nec placerat orci egestas. Fusce sed ipsum libero. Nullam quis sagittis ipsum, id mollis erat. Cras volutpat eget elit vel vehicula. Nulla dictum leo ac leo tempor, et dictum felis sodales.

                          Cras venenatis orci vitae risus eleifend, ac laoreet mauris vulputate. Nulla ut justo hendrerit, convallis nunc sed, feugiat erat. Phasellus vulputate est id libero scelerisque, et volutpat nisl fermentum. Proin condimentum purus id mi tempus ultricies. Fusce sed sagittis ante, id eleifend turpis. Nunc congue urna vel tincidunt scelerisque. Etiam at augue id libero aliquam pharetra. Donec facilisis vel lorem eget laoreet. Nulla ultricies orci in nulla auctor, ut auctor purus dictum. Curabitur et justo in lorem fermentum vehicula vel nec nisi.

                          Curabitur sed dolor at enim convallis varius. Mauris non ultricies sapien. Fusce vehicula lorem vel lorem fringilla, in suscipit urna efficitur. Sed varius eros sed augue laoreet, sit amet dictum turpis tristique. Integer ultricies augue quis tincidunt tempor. Phasellus vitae elit tincidunt, fermentum risus eu, laoreet mi. Nunc molestie ex et nulla luctus mollis. Nam gravida ultricies turpis, at interdum lacus varius id. Fusce laoreet, lorem vitae bibendum finibus, enim augue sollicitudin purus, sed fermentum metus ligula nec ligula. Sed vitae magna vehicula, vulputate sapien ut, tempor ligula.
                    ') }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection