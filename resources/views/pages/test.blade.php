
                            <div id="collapse{{ $group['name'] }}" class="panel-collapse collapse">
                                <div class="panel-body panel-square" >
                                    @foreach($group['members'] as $member)
                                    <div class="col-md-{{ 12/count($group['members']) }}">
                                        <h4 class="white">{{ $member['name'] }}</h4>
                                        <table class="table">
                                            @if ($group['showAwardType'])
                                                @foreach($awardType as $sh)
                                                <tr>
                                                    <td><a href="#myPopup" v-if="{{ $member['awardType'][$sh] ? 'true' : 'false' }}" v-on:click.prevent="{{ $member['className'] .'_'. $sh =! $member['className'] .'_'. $sh }}">{{ strtoupper($sh) }}</a></td>
                                                </tr>

                                                @foreach($rankingForAll as $action)
                                                <tr v-if="{{ $member['className'] }}_{{ $sh }}">
                                                    <td> - <a href="#myPopup" v-on:click.prevent='handleClick("{{ $member['role'] }}","{{ $action }}","{{ $sh }}")'>{{ $action }}</a></td>
                                                </tr>
                                                @endforeach
                                                @endforeach
                                            @elseif ($group['forAll'])
                                                @foreach($rankingForAll as $action)
                                                <tr>
                                                    <td><a href="#myPopup" v-on:click.prevent='handleClick("{{ $member['role'] }}","{{ $action }}")'>{{ $action }}</a></td>
                                                </tr>
                                                @endforeach
                                            @else
                                                @foreach($rankingForNationalOnly as $action)
                                                <tr>
                                                    <td><a href="#myPopup" v-on:click.prevent='handleClick("{{ $member['role'] }}","{{ $action }}")'>{{ $action }}</a></td>
                                                </tr>
                                                @endforeach
                                            @endif
                                        </table>
                                    </div>
                                    @endforeach
                                </div>
                            </div>




                            <div id="collapse{{ $group['name'] }}" class="panel-collapse collapse">
                                <div class="panel-body panel-square" >
                                    @foreach($group['members'] as $member)
                                    <div class="col-md-{{ 12/count($group['members']) }}">
                                        <h4 class="white">{{ $member['name'] }}</h4>
                                        <table class="table">
                                            @if($group['forAll'])
                                                @foreach($rankingForAll as $action)
                                                <tr>
                                                    <td><a href="#myPopup" v-on:click.prevent='handleClick("{{ $member['role'] }}","{{ $action }}")'>{{ $action }}</a></td>
                                                </tr>
                                                @endforeach
                                            @else
                                                @foreach($rankingForNationalOnly as $action)
                                                <tr>
                                                    <td><a href="#myPopup" v-on:click.prevent='handleClick("{{ $member['role'] }}","{{ $action }}")'>{{ $action }}</a></td>
                                                </tr>
                                                @endforeach
                                            @endif
                                        </table>
                                    </div>
                                    @endforeach
                                </div>
                            </div>





        <div class="card-group d-flex flex-column col-12 page-section-wrap">
            @foreach($faqs as $faq)
            <div class="card mb-1" style="border: 1px solid rgba(0, 0, 0, 0.125);border-radius: 3px;">
                <div class="card-header">
                    <a data-bs-toggle="collapse" href="{{ '#collapse-' . $faq->id }}" aria-expanded="false" aria-controls="{{ '#collapse-' . $faq->id }}" role="button"><strong>{{ $faq->question }}</strong></a>
                </div>
                <div id="{{ 'collapse-' . $faq->id }}" class="collapse">
                    <div class="card-body">
                        <p>{!! $faq->answer !!}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>


            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <div class="accordion-header" id="headingOne">
                        <a class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Accordion Item #1
                        </a>
                    </div>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Accordion Item #2
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Accordion Item #3
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div>
            </div>
