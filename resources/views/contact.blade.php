@php($page = 'contact')

@extends('layouts.master')

@section('title', 'Contact Us')

@section('body')
    <section class="contact-page" aria-labelledby="contact-title">
        <div class="contact-layout">
            <div class="contact-intro">
                <p class="section-kicker mb-3">Get in touch</p>
                <h1 id="contact-title">We would like to hear from you.</h1>
                <p class="contact-lead">
                    Have a story idea, a question about our publication, or feedback for the editorial team?
                    Send us a message and we will get back to you as soon as possible.
                </p>

                <div class="contact-note">
                    <span class="contact-note-mark" aria-hidden="true">MWN</span>
                    <div>
                        <h2>Editorial enquiries</h2>
                        <p class="mb-0">Use this form for general questions, corrections, and story suggestions.</p>
                    </div>
                </div>
            </div>

            <div class="contact-form-panel">
                <div class="contact-form-heading">
                    <p class="section-kicker mb-2">Send a message</p>
                    <h2>How can we help?</h2>
                    <p>All fields are required.</p>
                </div>

                <form class="contact-form" method="POST" action="{{ route('contact.mail') }}"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="contact-field">
                        <label for="inputEmail" class="form-label">E-mail</label>
                        <input name="email" type="email" class="form-control" id="inputEmail"
                            placeholder="you@example.com" maxlength="255" required="required"
                            value="{{ old('email') }}">
                    </div>

                    <div class="contact-field">
                        <label for="inputName" class="form-label">Name</label>
                        <input name="sender" type="text" class="form-control" id="inputName"
                            placeholder="Your name" maxlength="255" required="required"
                            value="{{ old('name') }}">
                    </div>

                    <div class="contact-field">
                        <label for="inputSubject" class="form-label">Subject</label>
                        <input name="subject" type="text" class="form-control" id="inputSubject"
                            placeholder="What would you like to discuss?" maxlength="255" required="required"
                            value="{{ old('subject') }}">
                    </div>

                    <div class="contact-field">
                        <label for="inputMessage" class="form-label">Message</label>
                        <textarea name="msg" id="inputMessage" maxlength="2048" class="form-control" rows="7"
                            placeholder="Write your message here…" required="required">{{ old('message') }}</textarea>
                        <p class="contact-field-help mb-0">Maximum 2,048 characters.</p>
                    </div>

                    <div class="contact-actions d-flex flex-column flex-sm-row gap-3">
                        <button type="submit" class="btn contact-submit">Send message</button>
                        <button type="reset" class="btn contact-reset">Clear form</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
