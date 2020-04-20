@extends('layouts.full')

@section('title', 'Novel Voices | Story Probe')
@section('header', "Story Probe: {$story->title}")

@section('styles')
  <style media="screen">
    .list-group-item {
      background: none;
    }

    /* Chat UI */
    .card {
      max-height: 70vh;
    }

    .msg-card-body{
			overflow-y: auto;
		}

    .msg-container {
      max-width: 60%;
  		border-radius: 10px;
  		padding: 10px;
  		position: relative;
      box-shadow: 4px 4px 4px var(--secondary-dark);
  	}

    .msg-container-receive {
      background-color: var(--ternary);
    }

  	.msg-container-send {
  		background-color: var(--secondary);
  	}

    .type-msg {
      border-radius: 10px 0 0 10px;
			height: 60px !important;
			overflow-y: auto;
		}

    .send-btn {
    	border-radius: 0 15px 15px 0;
      background-color: var(--highlight);
			border: 0;
			color: white;
			cursor: pointer;
		}

    .clickable-text {
      background-color: var(--ternary-dark);
      color: white;
      border-radius: 10px;
      padding: 3px;
      margin: 2px;
      box-shadow: 1px 1px 4px var(--ternary-dark);
      white-space: nowrap;
    }

    .clickable-text:hover {
      cursor: pointer;
    }
    /* End Chat UI */
  </style>
@endsection

@section('content')
  <div class="row">
    {{-- List of characters in this story --}}
    <div class="col-12 col-md-4">
      <div class="list-group-flush character-list">
        @forelse($story->characters as $character)
          <div class="list-group-item">
            <div class="d-flex character-info" data-name="{{str_replace(' ', '_', $character->name)}}">
              <div class="mr-4">
                <div class="character-item-circle" style="background-image: linear-gradient(to bottom right, {{$character->color1}}, {{$character->color2}})"></div>
              </div>
              <div class=" d-flex align-items-center">
                <div class="">
                  <h4>{{$character->name}}</h4>
                  <div>{{$character->archetype->name}}</div>
                </div>
              </div>
            </div>
          </div>
        @empty
          <div class="list-group-item d-flex align-items-center mx-3 font-italic">
            <h5>You currently have no characters for this story.</h5>
          </div>
        @endforelse
      </div>
    </div>

    {{-- Chat dialogue --}}
    <div class="col-12 col-md-8">
			<div class="card">
				<div id="chat-window" class="card-body msg-card-body">
					<div class="d-flex justify-content-start mb-4">
						<div class="msg-container msg-container-receive">
							Hi, I'm the story probe.  You need help to clear that writer's block for your story <span class="font-italic">{{$story->title}}</span>?  Let me help you out.
						</div>
					</div>
          <div class="d-flex justify-content-start mb-4">
						<div class="msg-container msg-container-receive">
							If you have a specific block, write that, otherwise pick one of the characters from the left to begin.
						</div>
					</div>
				</div>
				<div class="card-footer">
					<div class="input-group">
            <textarea id="text-field" class="form-control type-msg" placeholder="Type your message..."></textarea>
						<div class="input-group-append">
							<span class="input-group-text send-btn"><i class="fas fa-location-arrow"></i></span>
						</div>
					</div>
				</div>
			</div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
      // clicking on a character automatically puts its name in the text area
      $('.character-info').click(function() {
        let $textfield = $('#text-field');
        $textfield.val(`${$textfield.val()} @${$(this).data('name')}`);
      });

      // clicking on clickable text automatically appends to chat and sends request
      $('#chat-window').on('click', '.clickable-text', function() {
        let $textfield = $('#text-field');
        $textfield.val(`${$textfield.val()} #${$(this).text().replace(' ', '_')}`);
        $('.send-btn').click();
      });

      // handles the 'send' button
      let waitForReplies = false;
      let probeResponses = [];
      $('.send-btn').on('click', function() {
        let $textfield = $('#text-field');
        let message = $textfield.val();

        appendToChat(true, message);

        // clear the text area
        $textfield.val('');

        if(probeResponses.length > 0) { // have stock messages, print those rather than send to backend
          appendToChat(false, probeResponses[0].replace('_', ' '));
          probeResponses.splice(0, 1);
        }
        else {
          // send to backend
          sendMessage(message).then(response => {
            console.log(response);
            if(response['todo'] === 'post') {
              initProbing(response['messages']);

              // append the response message
              appendToChat(false, probeResponses[0].replace('_', ' '));
              probeResponses.splice(0, 1);
            }
            else if(response['todo'] === 'entityAnalysis') {
              waitForReplies = false;

              // query google NLP entity analysis
              entityAnalysis(response['original']).then(response => {
                console.log(response);

                // send results to backend for parsing
                parseEntities(response).then(response => {
                  console.log(response);

                  if(response['todo'] === 'new_prompt') {
                    appendToChat(false, response['message']);
                  }
                  else if(response['todo'] === 'post') {
                    initProbing(response['messages']);

                    // append the response message
                    appendToChat(false, probeResponses[0].replace('_', ' '));
                    probeResponses.splice(0, 1);
                  }
                  else if(response['todo'] === 'clickables') {
                    waitForReplies = false;

                    // create spans of clickable items
                    let spans = [];
                    response.entities.forEach(function(entity) {
                      let span = document.createElement('span');
                      span.classList.add('clickable-text');
                      span.innerText = entity.name;
                      let dataAttr = document.createAttribute('data-type');
                      dataAttr.value = entity.type;
                      span.setAttributeNode(dataAttr);
                      spans.push(span);
                    });

                    appendToChat(false, response['message'], spans);
                  }
                });
              });
            }
          });
        }
      });

      async function sendMessage(message) {
        let response = await fetch('/probe/message', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json;charset=utf-8',
          },
          body: JSON.stringify({
            "_token": "{{ csrf_token() }}",
            'message': message
          })
        });
        return response.json();
      }

      async function parseEntities(entities) {
        let response = await fetch('/probe/entities', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json;charset=utf-8',
          },
          body: JSON.stringify({
            "_token": "{{ csrf_token() }}",
            'entities': entities['entities']
          })
        });
        return response.json();
      }

      async function entityAnalysis(message) {
        let response = await fetch("{{env('GCP_NLP_API')}}", {
          method: 'POST',
          body: JSON.stringify({
            'document': {
              "type": 'PLAIN_TEXT',
              "content": message
            },
            'encodingType': 'NONE'
          })
        });
        return response.json();
      }

      function appendToChat(isSender, message, clickables = 0) {
        let chatWindow = document.querySelector('#chat-window');

        // create the DOM elements
        let div = document.createElement('div');
        div.classList.add('d-flex', `justify-content-${isSender ? 'end' : 'start'}`, 'mb-4');
        let innerDiv = document.createElement('div');
        innerDiv.classList.add('msg-container', `msg-container-${isSender ? 'send' : 'receive'}`);
        innerDiv.innerHTML = message;

        // append all clickables if they exist
        if(clickables) {
          clickables.forEach(function(clickable) {
            innerDiv.appendChild(clickable);
          });
        }

        div.appendChild(innerDiv);
        chatWindow.appendChild(div);

        // scroll appropriately
        chatWindow.scrollTop = chatWindow.scrollHeight;
      }

      function initProbing(responses) {
        waitForReplies = true;
        probeResponses = responses;
      }
    });
  </script>
@endsection
