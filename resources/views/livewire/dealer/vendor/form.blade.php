<form class="space-y-5" action="#">

    <div class="bg-gray-100 rounded-md">
        <div class="p-10">
            <label class="text-base font-medium text-gray-900">Are you an employee or authorized representative of
                this vendor/company? Indicate the Person’s Name in the comments</label>
            <fieldset class="mt-4">
                <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                    <div class="flex items-center">
                        <input value="one-yes" id="one-yes" name="one" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="one-yes" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                    </div>

                    <div class="flex items-center">
                        <input value="one-no" id="one-no" name="one" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="one-no" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                    </div>

                    <div class="flex items-center">
                        <input value="one-na" id="one-na" name="one" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="one-na" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                    </div>
                </div>
            </fieldset>
            <div class="mt-5">
                <label for="comment" class="block text-sm font-medium text-gray-700">Comments</label>
                <div class="mt-1">
                        <textarea rows="4" name="comment" id="comment" placeholder="Person's Name:"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-100 rounded-md">
        <div class="p-10">
            <label class="text-base font-medium text-gray-900">Does your company offer software applications as part
                of its services?</label>
            <fieldset class="mt-4">
                <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                    <div class="flex items-center">
                        <input id="email" name="two" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                    </div>

                    <div class="flex items-center">
                        <input id="sms" name="two" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                    </div>

                    <div class="flex items-center">
                        <input id="push" name="two" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="push" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                    </div>
                </div>
            </fieldset>
            <div class="mt-5">
                <label for="comment" class="block text-sm font-medium text-gray-700">Comments</label>
                <div class="mt-1">
                        <textarea rows="4" name="comment" id="comment"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-100 rounded-md">
        <div class="p-10">
            <label class="text-base font-medium text-gray-900">Is client data encrypted at rest and in transit? If
                not, why not?</label>
            <fieldset class="mt-4">
                <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                    <div class="flex items-center">
                        <input id="email" name="three" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                    </div>

                    <div class="flex items-center">
                        <input id="sms" name="three" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                    </div>

                    <div class="flex items-center">
                        <input id="push" name="three" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="push" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                    </div>
                </div>
            </fieldset>
            <div class="mt-5">
                <label for="comment" class="block text-sm font-medium text-gray-700">Comments</label>
                <div class="mt-1">
                        <textarea rows="4" name="comment" id="comment"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-100 rounded-md">
        <div class="p-10">
            <label class="text-base font-medium text-gray-900">Has your company experienced a data breach in the
                past 12 months that affected customers’ personal information?</label>
            <fieldset class="mt-4">
                <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                    <div class="flex items-center">
                        <input id="email" name="four" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                    </div>

                    <div class="flex items-center">
                        <input id="sms" name="four" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                    </div>

                    <div class="flex items-center">
                        <input id="push" name="four" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="push" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                    </div>
                </div>
            </fieldset>
            <div class="mt-5">
                <label for="comment" class="block text-sm font-medium text-gray-700">Comments</label>
                <div class="mt-1">
                        <textarea rows="4" name="comment" id="comment"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-100 rounded-md">
        <div class="p-10">
            <label class="text-base font-medium text-gray-900">Does your company have insurance coverage for a data
                breach that may involve our customers’ information that your company acquires while doing business
                with us?</label>
            <fieldset class="mt-4">
                <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                    <div class="flex items-center">
                        <input id="email" name="five" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                    </div>

                    <div class="flex items-center">
                        <input id="sms" name="five" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                    </div>

                    <div class="flex items-center">
                        <input id="push" name="five" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="push" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                    </div>
                </div>
            </fieldset>
            <div class="mt-5">
                <label for="comment" class="block text-sm font-medium text-gray-700">Comments</label>
                <div class="mt-1">
                        <textarea rows="4" name="comment" id="comment"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-100 rounded-md">
        <div class="p-10">
            <label class="text-base font-medium text-gray-900">Does your company require security awareness training
                for all employees? If so, please answer how often it is provided in the comments section.</label>
            <fieldset class="mt-4">
                <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                    <div class="flex items-center">
                        <input id="email" name="six" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                    </div>

                    <div class="flex items-center">
                        <input id="sms" name="six" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                    </div>

                    <div class="flex items-center">
                        <input id="push" name="six" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="push" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                    </div>
                </div>
            </fieldset>
            <div class="mt-5">
                <label for="comment" class="block text-sm font-medium text-gray-700">Comments</label>
                <div class="mt-1">
                        <textarea rows="4" name="comment" id="comment" placeholder="Security Training Frequency:"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-100 rounded-md">
        <div class="p-10">
            <label class="text-base font-medium text-gray-900">Does your company monitor for the effectiveness of
                employee security training by testing your users with simulated attacks?</label>
            <fieldset class="mt-4">
                <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                    <div class="flex items-center">
                        <input id="email" name="seven" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                    </div>

                    <div class="flex items-center">
                        <input id="sms" name="seven" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                    </div>

                    <div class="flex items-center">
                        <input id="push" name="seven" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="push" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                    </div>
                </div>
            </fieldset>
            <div class="mt-5">
                <label for="comment" class="block text-sm font-medium text-gray-700">Comments</label>
                <div class="mt-1">
                        <textarea rows="4" name="comment" id="comment"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-100 rounded-md">
        <div class="p-10">
            <label class="text-base font-medium text-gray-900">Does your company have a process for restricting
                access to customer files on a need-to-know basis?</label>
            <fieldset class="mt-4">
                <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                    <div class="flex items-center">
                        <input id="email" name="eight" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                    </div>

                    <div class="flex items-center">
                        <input id="sms" name="eight" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                    </div>

                    <div class="flex items-center">
                        <input id="push" name="eight" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="push" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                    </div>
                </div>
            </fieldset>
            <div class="mt-5">
                <label for="comment" class="block text-sm font-medium text-gray-700">Comments</label>
                <div class="mt-1">
                        <textarea rows="4" name="comment" id="comment"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-100 rounded-md">
        <div class="p-10">
            <label class="text-base font-medium text-gray-900">Do you have a written information security
                program?</label>
            <fieldset class="mt-4">
                <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                    <div class="flex items-center">
                        <input id="email" name="nine" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                    </div>

                    <div class="flex items-center">
                        <input id="sms" name="nine" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                    </div>

                    <div class="flex items-center">
                        <input id="push" name="nine" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="push" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                    </div>
                </div>
            </fieldset>
            <div class="mt-5">
                <label for="comment" class="block text-sm font-medium text-gray-700">Comments</label>
                <div class="mt-1">
                        <textarea rows="4" name="comment" id="comment"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-100 rounded-md">
        <div class="p-10">
            <label class="text-base font-medium text-gray-900">Does your company conduct annual risk assessments
                that assess electronic, physical, and administrative information safeguards?</label>
            <fieldset class="mt-4">
                <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                    <div class="flex items-center">
                        <input id="email" name="ten" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                    </div>

                    <div class="flex items-center">
                        <input id="sms" name="ten" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                    </div>

                    <div class="flex items-center">
                        <input id="push" name="ten" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="push" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                    </div>
                </div>
            </fieldset>
            <div class="mt-5">
                <label for="comment" class="block text-sm font-medium text-gray-700">Comments</label>
                <div class="mt-1">
                        <textarea rows="4" name="comment" id="comment"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-100 rounded-md">
        <div class="p-10">
            <label class="text-base font-medium text-gray-900">Does your company have systems in place to securely
                dispose of documents that have personal identifiable information on them?</label>
            <fieldset class="mt-4">
                <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                    <div class="flex items-center">
                        <input id="email" name="eleven" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                    </div>

                    <div class="flex items-center">
                        <input id="sms" name="eleven" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                    </div>

                    <div class="flex items-center">
                        <input id="push" name="eleven" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="push" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                    </div>
                </div>
            </fieldset>
            <div class="mt-5">
                <label for="comment" class="block text-sm font-medium text-gray-700">Comments</label>
                <div class="mt-1">
                        <textarea rows="4" name="comment" id="comment"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-100 rounded-md">
        <div class="p-10">
            <label class="text-base font-medium text-gray-900">Does your company have systems in place to restrict
                access to files/documents containing customers personal information to those with proper
                authorization?</label>
            <fieldset class="mt-4">
                <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                    <div class="flex items-center">
                        <input id="email" name="twelve" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                    </div>

                    <div class="flex items-center">
                        <input id="sms" name="twelve" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                    </div>

                    <div class="flex items-center">
                        <input id="push" name="twelve" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="push" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                    </div>
                </div>
            </fieldset>
            <div class="mt-5">
                <label for="comment" class="block text-sm font-medium text-gray-700">Comments</label>
                <div class="mt-1">
                        <textarea rows="4" name="comment" id="comment"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-100 rounded-md">
        <div class="p-10">
            <label class="text-base font-medium text-gray-900">Does your company have due diligence processes and
                procedures for vetting subcontractors, including having them sign processing agreements that are
                compliant with applicable federal and state laws?</label>
            <fieldset class="mt-4">
                <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                    <div class="flex items-center">
                        <input id="email" name="thirteen" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                    </div>

                    <div class="flex items-center">
                        <input id="sms" name="thirteen" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                    </div>

                    <div class="flex items-center">
                        <input id="push" name="thirteen" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="push" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                    </div>
                </div>
            </fieldset>
            <div class="mt-5">
                <label for="comment" class="block text-sm font-medium text-gray-700">Comments</label>
                <div class="mt-1">
                        <textarea rows="4" name="comment" id="comment"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-100 rounded-md">
        <div class="p-10">
            <label class="text-base font-medium text-gray-900">Has your company performed penetration testing of its
                systems within the past 12 months?</label>
            <fieldset class="mt-4">
                <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                    <div class="flex items-center">
                        <input id="email" name="fourteen" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                    </div>

                    <div class="flex items-center">
                        <input id="sms" name="fourteen" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                    </div>

                    <div class="flex items-center">
                        <input id="push" name="fourteen" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="push" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                    </div>
                </div>
            </fieldset>
            <div class="mt-5">
                <label for="comment" class="block text-sm font-medium text-gray-700">Comments</label>
                <div class="mt-1">
                        <textarea rows="4" name="comment" id="comment"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-100 rounded-md">
        <div class="p-10">
            <label class="text-base font-medium text-gray-900">Has your company conducted a vulnerability assessment
                of your systems within the past 6 months?</label>
            <fieldset class="mt-4">
                <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                    <div class="flex items-center">
                        <input id="email" name="fifteen" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                    </div>

                    <div class="flex items-center">
                        <input id="sms" name="fifteen" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                    </div>

                    <div class="flex items-center">
                        <input id="push" name="fifteen" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="push" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                    </div>
                </div>
            </fieldset>
            <div class="mt-5">
                <label for="comment" class="block text-sm font-medium text-gray-700">Comments</label>
                <div class="mt-1">
                        <textarea rows="4" name="comment" id="comment"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-100 rounded-md">
        <div class="p-10">
            <label class="text-base font-medium text-gray-900">Does your company maintain end-of-life or unsupported
                operating systems or software? If so, are these systems used to manage or maintain customer
                data?</label>
            <fieldset class="mt-4">
                <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                    <div class="flex items-center">
                        <input id="email" name="sixteen" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                    </div>

                    <div class="flex items-center">
                        <input id="sms" name="sixteen" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                    </div>

                    <div class="flex items-center">
                        <input id="push" name="sixteen" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="push" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                    </div>
                </div>
            </fieldset>
            <div class="mt-5">
                <label for="comment" class="block text-sm font-medium text-gray-700">Comments</label>
                <div class="mt-1">
                        <textarea rows="4" name="comment" id="comment"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-100 rounded-md">
        <div class="p-10">
            <label class="text-base font-medium text-gray-900">Does your company regularly patch or update systems
                and third-party software and monitor for noncompliance?</label>
            <fieldset class="mt-4">
                <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                    <div class="flex items-center">
                        <input id="email" name="seventeen" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                    </div>

                    <div class="flex items-center">
                        <input id="sms" name="seventeen" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                    </div>

                    <div class="flex items-center">
                        <input id="push" name="seventeen" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="push" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                    </div>
                </div>
            </fieldset>
            <div class="mt-5">
                <label for="comment" class="block text-sm font-medium text-gray-700">Comments</label>
                <div class="mt-1">
                        <textarea rows="4" name="comment" id="comment"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-100 rounded-md">
        <div class="p-10">
            <label class="text-base font-medium text-gray-900">Does your company have a written incident response
                plan in the event of a security breach?</label>
            <fieldset class="mt-4">
                <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                    <div class="flex items-center">
                        <input id="email" name="eighteen" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                    </div>

                    <div class="flex items-center">
                        <input id="sms" name="eighteen" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                    </div>

                    <div class="flex items-center">
                        <input id="push" name="eighteen" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="push" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                    </div>
                </div>
            </fieldset>
            <div class="mt-5">
                <label for="comment" class="block text-sm font-medium text-gray-700">Comments</label>
                <div class="mt-1">
                        <textarea rows="4" name="comment" id="comment"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-100 rounded-md">
        <div class="p-10">
            <label class="text-base font-medium text-gray-900">Does your company require users to create complex
                passwords with 9 characters or greater?</label>
            <fieldset class="mt-4">
                <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                    <div class="flex items-center">
                        <input id="email" name="nineteen" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                    </div>

                    <div class="flex items-center">
                        <input id="sms" name="nineteen" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                    </div>

                    <div class="flex items-center">
                        <input id="push" name="nineteen" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="push" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                    </div>
                </div>
            </fieldset>
            <div class="mt-5">
                <label for="comment" class="block text-sm font-medium text-gray-700">Comments</label>
                <div class="mt-1">
                        <textarea rows="4" name="comment" id="comment"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-100 rounded-md">
        <div class="p-10">
            <label class="text-base font-medium text-gray-900">Does your company prohibit shared logins?</label>
            <fieldset class="mt-4">
                <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                    <div class="flex items-center">
                        <input id="email" name="twenty" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                    </div>

                    <div class="flex items-center">
                        <input id="sms" name="twenty" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                    </div>

                    <div class="flex items-center">
                        <input id="push" name="twenty" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="push" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                    </div>
                </div>
            </fieldset>
            <div class="mt-5">
                <label for="comment" class="block text-sm font-medium text-gray-700">Comments</label>
                <div class="mt-1">
                        <textarea rows="4" name="comment" id="comment"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-100 rounded-md">
        <div class="p-10">
            <label class="text-base font-medium text-gray-900">Does your company require multi-factor authentication
                to log into your company’s systems?</label>
            <fieldset class="mt-4">
                <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                    <div class="flex items-center">
                        <input id="email" name="twentyone" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                    </div>

                    <div class="flex items-center">
                        <input id="sms" name="twentyone" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                    </div>

                    <div class="flex items-center">
                        <input id="push" name="twentyone" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="push" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                    </div>
                </div>
            </fieldset>
            <div class="mt-5">
                <label for="comment" class="block text-sm font-medium text-gray-700">Comments</label>
                <div class="mt-1">
                        <textarea rows="4" name="comment" id="comment"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-100 rounded-md">
        <div class="p-10">
            <label class="text-base font-medium text-gray-900">Do you have an account lockout policy?</label>
            <fieldset class="mt-4">
                <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                    <div class="flex items-center">
                        <input id="email" name="twentytwo" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                    </div>

                    <div class="flex items-center">
                        <input id="sms" name="twentytwo" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                    </div>

                    <div class="flex items-center">
                        <input id="push" name="twentytwo" type="radio"
                               class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                        <label for="push" class="ml-3 block text-sm font-medium text-gray-700">N/A</label>
                    </div>
                </div>
            </fieldset>
            <div class="mt-5">
                <label for="comment" class="block text-sm font-medium text-gray-700">Comments</label>
                <div class="mt-1">
                        <textarea rows="4" name="comment" id="comment"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Name of Person Completing This
            Form:</label>
        <div class="mt-1">
            <input type="text" name="name" id="name"
                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
        </div>
    </div>

    <div>
        <label for="company" class="block text-sm font-medium text-gray-700">Company Name:</label>
        <div class="mt-1">
            <input type="text" name="company" id="company"
                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
        </div>
    </div>

    <div>
        <button class="bg-arm-blue-500 py-3 px-5 rounded-md text-white">Submit</button>
    </div>

</form>
