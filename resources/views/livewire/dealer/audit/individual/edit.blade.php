<form class="md:px-4">
    <div class="space-y-5">
        <!-- Audit Date -->
        <div class="ml-3 md:ml-0">
            <label for="audit_date" class="block text-sm font-medium leading-6 text-gray-900">Audit Date</label>
            <div class="mt-2">
                <input
                    wire:model="audit_date"
                    type="date"
                    name="audit_date"
                    id="audit_date"
                    pattern=""
                    class="block w-1/2 sm:w-1/3 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"
                />
            </div>
        </div>
        <!-- Deal Jacket Date -->
        <div class="ml-3 md:ml-0">
            <label for="deal_jacket_date" class="block text-sm font-medium leading-6 text-gray-900">Deal Jacket
                Date</label>
            <div class="mt-2">
                <input
                    wire:model="deal_jacket_date"
                    type="date"
                    name="deal_jacket_date"
                    id="deal_jacket_date"
                    pattern=""
                    class="block w-1/2 sm:w-1/3 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"
                />
            </div>
        </div>
        <!-- Customer Name -->
        <div class="ml-3 md:ml-0">
            <label for="customer_name" class="block text-sm font-medium leading-6 text-gray-900">Customer
                Name</label>
            <div class="mt-2">
                <input
                    wire:model.lazy="customer_name"
                    type="text"
                    name="customer_name"
                    id="customer_name"
                    class="block w-1/2 sm:w-1/3 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"
                />
            </div>
        </div>
        <!-- Customer Number -->
        <div class="ml-3 md:ml-0">
            <label for="customer_number" class="block text-sm font-medium leading-6 text-gray-900">Customer
                Number</label>
            <div class="mt-2">
                <input
                    wire:model.lazy="customer_number"
                    type="text"
                    name="customer_number"
                    id="customer_number"
                    class="block w-1/2 sm:w-1/3 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"
                />
            </div>
        </div>
        <!-- Manager Name -->
        <div class="ml-3 md:ml-0">
            <label for="manager_id" class="block text-sm font-medium leading-6 text-gray-900">Finance Manager</label>
            <div class="mt-2">
                <select wire:model="manager_id" id="manager_id" name="manager_id" autocomplete="cmanager_id"
                        class="block w-1/2 sm:w-1/3 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6">
                    <option></option>
                    @foreach($managers as $manager)
                        <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <!-- Mileage -->
        <div class="ml-3 md:ml-0">
            <label for="customer_number" class="block text-sm font-medium leading-6 text-gray-900">Mileage</label>
            <div class="mt-2">
                <input
                    wire:model.lazy="mileage"
                    type="number"
                    name="mileage"
                    id="mileage"
                    class="block w-1/2 sm:w-1/3 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"
                />
            </div>
        </div>
        <!-- Cash or Finance? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Cash, Finance or Lease?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q1_answer"
                                value="1"
                                name="individual_q1_answer"
                                id="individual_q1_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q1_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Cash</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q1_answer"
                                value="2"
                                name="individual_q1_answer"
                                id="individual_q1_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q1_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Finance</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q1_answer"
                                value="3"
                                name="individual_q1_answer"
                                id="individual_q1_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q1_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Lease</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q1_danger"
                            id="individual_q1_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q1_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q1_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q1_comment" id="individual_q1_comment"
                          name="individual_q1_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- New or Used? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">New or Used?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q2_answer"
                                value="1"
                                name="individual_q2_answer"
                                id="individual_q2_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q2_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">New</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q2_answer"
                                value="2"
                                name="individual_q2_answer"
                                id="individual_q2_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q2_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Used</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q2_danger"
                            id="individual_q2_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q2_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q2_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q2_comment" id="individual_q1_comment"
                          name.lazy="individual_q2_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- Is there an Odometer Statement in deal? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Is there an Odometer Statement in deal?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q3_answer"
                                value="1"
                                name="individual_q3_answer"
                                id="individual_q3_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q3_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q3_answer"
                                value="2"
                                name="individual_q3_answer"
                                id="individual_q3_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q3_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q3_answer"
                                value="3"
                                name="individual_q3_answer"
                                id="individual_q3_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q3_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q3_danger"
                            id="individual_q3_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q3_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q3_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q3_comment" id="individual_q1_comment"
                          name.lazy="individual_q3_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- Did deal have two page model Privacy Notice statement and was it signed? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Did deal have two page model Privacy Notice
                    statement and was it signed?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q4_answer"
                                value="1"
                                name="individual_q4_answer"
                                id="individual_q4_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q4_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q4_answer"
                                value="2"
                                name="individual_q4_answer"
                                id="individual_q4_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q4_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q4_answer"
                                value="3"
                                name="individual_q4_answer"
                                id="individual_q4_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q4_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q4_danger"
                            id="individual_q4_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q4_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q4_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q4_comment" id="individual_q1_comment"
                          name.lazy="individual_q4_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- Menu Present? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Menu Present?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q5_answer"
                                value="1"
                                name="individual_q5_answer"
                                id="individual_q5_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q5_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q5_answer"
                                value="2"
                                name="individual_q5_answer"
                                id="individual_q5_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q5_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q5_answer"
                                value="3"
                                name="individual_q5_answer"
                                id="individual_q5_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q5_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q5_danger"
                            id="individual_q5_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q5_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q5_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q5_comment" id="individual_q1_comment"
                          name.lazy="individual_q5_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- Is the Menu filled out properly? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Is the Menu filled out properly?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q6_answer"
                                value="1"
                                name="individual_q6_answer"
                                id="individual_q6_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q6_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q6_answer"
                                value="2"
                                name="individual_q6_answer"
                                id="individual_q6_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q6_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q6_answer"
                                value="3"
                                name="individual_q6_answer"
                                id="individual_q6_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q6_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q6_danger"
                            id="individual_q6_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q6_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q6_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q6_comment" id="individual_q1_comment"
                          name.lazy="individual_q6_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- Is there a separate signed contract for each product sold on menu? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Is there a separate signed contract for each
                    product sold on menu?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q7_answer"
                                value="1"
                                name="individual_q7_answer"
                                id="individual_q7_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q7_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q7_answer"
                                value="2"
                                name="individual_q7_answer"
                                id="individual_q7_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q7_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q7_answer"
                                value="3"
                                name="individual_q7_answer"
                                id="individual_q7_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q7_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q7_danger"
                            id="individual_q7_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q7_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q7_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q7_comment" id="individual_q1_comment"
                          name.lazy="individual_q7_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- Are all customers being treated the same regarding product markups on menu system? If no explain -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are all customers being treated the same regarding
                    product markups on menu system? If no explain</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q8_answer"
                                value="1"
                                name="individual_q8_answer"
                                id="individual_q8_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q8_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q8_answer"
                                value="2"
                                name="individual_q8_answer"
                                id="individual_q8_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q8_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q8_answer"
                                value="3"
                                name="individual_q8_answer"
                                id="individual_q8_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q8_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q8_danger"
                            id="individual_q8_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q8_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q8_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q8_comment" id="individual_q1_comment"
                          name.lazy="individual_q8_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- Was OFAC run and on file either physically or electronically? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Was OFAC run and on file either physically or
                    electronically?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q9_answer"
                                value="1"
                                name="individual_q9_answer"
                                id="individual_q9_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q9_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q9_answer"
                                value="2"
                                name="individual_q9_answer"
                                id="individual_q9_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q9_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q9_answer"
                                value="3"
                                name="individual_q9_answer"
                                id="individual_q9_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q9_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q9_danger"
                            id="individual_q9_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q9_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q9_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q9_comment" id="individual_q1_comment"
                          name.lazy="individual_q9_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- Was the Red Flag software run and on file either physically or electronically? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Was the Red Flag software run and on file either
                    physically or electronically?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q10_answer"
                                value="1"
                                name="individual_q10_answer"
                                id="individual_q10_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q10_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q10_answer"
                                value="2"
                                name="individual_q10_answer"
                                id="individual_q10_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q10_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q10_answer"
                                value="3"
                                name="individual_q10_answer"
                                id="individual_q10_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q10_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q10_danger"
                            id="individual_q10_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q10_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q10_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q10_comment" id="individual_q1_comment"
                          name.lazy="individual_q10_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- Is there a copy of the Buyer's Guide in deal jacket? (if used car sold) -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Is there a copy of the Buyer's Guide in deal
                    jacket? (if used car sold)</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q11_answer"
                                value="1"
                                name="individual_q11_answer"
                                id="individual_q11_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q11_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q11_answer"
                                value="2"
                                name="individual_q11_answer"
                                id="individual_q11_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q11_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q11_answer"
                                value="3"
                                name="individual_q11_answer"
                                id="individual_q11_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q11_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q11_danger"
                            id="individual_q11_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q11_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q11_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q11_comment" id="individual_q1_comment"
                          name.lazy="individual_q11_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- If Buyer's Guide present is it filled out properly and signed by customer? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">If Buyer's Guide present is it filled out properly
                    and signed by customer?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q12_answer"
                                value="1"
                                name="individual_q12_answer"
                                id="individual_q12_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q12_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q12_answer"
                                value="2"
                                name="individual_q12_answer"
                                id="individual_q12_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q12_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q12_answer"
                                value="3"
                                name="individual_q12_answer"
                                id="individual_q12_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q12_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q12_danger"
                            id="individual_q12_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q12_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q12_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q12_comment" id="individual_q1_comment"
                          name.lazy="individual_q12_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- Was RBPN or Exception notice presented and signed by customer? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Was RBPN or Exception notice presented and signed
                    by customer?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q13_answer"
                                value="1"
                                name="individual_q13_answer"
                                id="individual_q13_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q13_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q13_answer"
                                value="2"
                                name="individual_q13_answer"
                                id="individual_q13_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q13_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q13_answer"
                                value="3"
                                name="individual_q13_answer"
                                id="individual_q13_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q13_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q13_danger"
                            id="individual_q13_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q13_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q13_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q13_comment" id="individual_q1_comment"
                          name.lazy="individual_q13_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- Does the Buyers Order & the RISC match up regarding final purchase price?  -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Does the Buyers Order & the RISC match up regarding
                    final purchase price? </label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q14_answer"
                                value="1"
                                name="individual_q14_answer"
                                id="individual_q14_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q14_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q14_answer"
                                value="2"
                                name="individual_q14_answer"
                                id="individual_q14_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q14_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q14_answer"
                                value="3"
                                name="individual_q14_answer"
                                id="individual_q14_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q14_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q14_danger"
                            id="individual_q14_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q14_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q14_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q14_comment" id="individual_q1_comment"
                          name.lazy="individual_q14_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- Does the Menu, Buyers Order & the RISC match up regarding ancillary products purchased? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Does the Menu, Buyers Order & the RISC match up
                    regarding ancillary products purchased?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q15_answer"
                                value="1"
                                name="individual_q15_answer"
                                id="individual_q15_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q15_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q15_answer"
                                value="2"
                                name="individual_q15_answer"
                                id="individual_q15_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q15_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q15_answer"
                                value="3"
                                name="individual_q15_answer"
                                id="individual_q15_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q15_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q15_danger"
                            id="individual_q15_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q15_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q15_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q15_comment" id="individual_q1_comment"
                          name.lazy="individual_q15_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- Products purchased or denied are "CLEARLY" displayed on the menu and or "Settlement Disclosure Document"? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Products purchased or denied are "CLEARLY"
                    displayed on the menu and or "Settlement Disclosure Document"?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q16_answer"
                                value="1"
                                name="individual_q16_answer"
                                id="individual_q16_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q16_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q16_answer"
                                value="2"
                                name="individual_q16_answer"
                                id="individual_q16_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q16_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q16_answer"
                                value="3"
                                name="individual_q16_answer"
                                id="individual_q16_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q16_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q16_danger"
                            id="individual_q16_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q16_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q16_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q16_comment" id="individual_q1_comment"
                          name.lazy="individual_q16_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- Check price of products on buyers order and RISC, Is the amount charged similar to that charged for other purchasers? If not explain. -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Check price of products on buyers order and RISC,
                    Is the amount charged similar to that charged for other purchasers? If not explain.</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q17_answer"
                                value="1"
                                name="individual_q17_answer"
                                id="individual_q17_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q17_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q17_answer"
                                value="2"
                                name="individual_q17_answer"
                                id="individual_q17_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q17_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q17_answer"
                                value="3"
                                name="individual_q17_answer"
                                id="individual_q17_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q17_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q17_danger"
                            id="individual_q17_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q17_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q17_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q17_comment" id="individual_q1_comment"
                          name.lazy="individual_q17_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- MSRP of Vehicle did not exceed price?? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">MSRP of Vehicle did not exceed price?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q18_answer"
                                value="1"
                                name="individual_q18_answer"
                                id="individual_q18_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q18_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q18_answer"
                                value="2"
                                name="individual_q18_answer"
                                id="individual_q18_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q18_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q18_answer"
                                value="3"
                                name="individual_q18_answer"
                                id="individual_q18_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q18_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q18_danger"
                            id="individual_q18_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q18_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q18_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q18_comment" id="individual_q1_comment"
                          name.lazy="individual_q18_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- Was deal sent to more than one finance source? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Was deal sent to more than one finance
                    source?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q19_answer"
                                value="1"
                                name="individual_q19_answer"
                                id="individual_q19_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q19_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q19_answer"
                                value="2"
                                name="individual_q19_answer"
                                id="individual_q19_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q19_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q19_answer"
                                value="3"
                                name="individual_q19_answer"
                                id="individual_q19_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q19_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q19_danger"
                            id="individual_q19_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q19_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q19_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q19_comment" id="individual_q1_comment"
                          name.lazy="individual_q19_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- Was credit application completed properly, accurate and signed by customer? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Was credit application completed properly, accurate
                    and signed by customer?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q20_answer"
                                value="1"
                                name="individual_q20_answer"
                                id="individual_q20_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q20_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q20_answer"
                                value="2"
                                name="individual_q20_answer"
                                id="individual_q20_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q20_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q20_answer"
                                value="3"
                                name="individual_q20_answer"
                                id="individual_q20_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q20_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q20_danger"
                            id="individual_q20_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q20_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q20_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q20_comment" id="individual_q1_comment"
                          name.lazy="individual_q20_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- If a handwritten credit application was present, it's signed and matches the bank copy regarding income, rent etc? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">If a handwritten credit application was present,
                    it's signed and matches the bank copy regarding income, rent etc?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q21_answer"
                                value="1"
                                name="individual_q21_answer"
                                id="individual_q21_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q21_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q21_answer"
                                value="2"
                                name="individual_q21_answer"
                                id="individual_q21_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q21_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q21_answer"
                                value="3"
                                name="individual_q21_answer"
                                id="individual_q21_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q21_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q21_danger"
                            id="individual_q21_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q21_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q21_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q21_comment" id="individual_q1_comment"
                          name.lazy="individual_q21_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- Was an Adverse Action filled out if warranted? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Was an Adverse Action filled out if
                    warranted?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q22_answer"
                                value="1"
                                name="individual_q22_answer"
                                id="individual_q22_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q22_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q22_answer"
                                value="2"
                                name="individual_q22_answer"
                                id="individual_q22_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q22_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q22_answer"
                                value="3"
                                name="individual_q22_answer"
                                id="individual_q22_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q22_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q22_danger"
                            id="individual_q22_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q22_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q22_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q22_comment" id="individual_q1_comment"
                          name.lazy="individual_q22_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- Is the DPP form filled out properly stating dealership CMS policy mark up rate and actual rate spread to cutomer? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Is the DPP form filled out properly stating
                    dealership CMS policy mark up rate and actual rate spread to customer?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q23_answer"
                                value="1"
                                name="individual_q23_answer"
                                id="individual_q23_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q23_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q23_answer"
                                value="2"
                                name="individual_q23_answer"
                                id="individual_q23_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q23_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q23_answer"
                                value="3"
                                name="individual_q23_answer"
                                id="individual_q23_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q23_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q23_danger"
                            id="individual_q23_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q23_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q23_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q23_comment" id="individual_q1_comment"
                          name.lazy="individual_q23_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- Are markups handled the same for similar customers, i.e. is it higher for protected class: sex, national origin, race, age, etc? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are markups handled the same for similar customers,
                    i.e. is it higher for protected class: sex, national origin, race, age, etc?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q24_answer"
                                value="1"
                                name="individual_q24_answer"
                                id="individual_q24_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q24_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q24_answer"
                                value="2"
                                name="individual_q24_answer"
                                id="individual_q24_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q24_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q24_answer"
                                value="3"
                                name="individual_q24_answer"
                                id="individual_q24_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q24_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q24_danger"
                            id="individual_q24_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q24_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q24_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q24_comment" id="individual_q1_comment"
                          name.lazy="individual_q24_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- Is the date on RISC accurate with no backdating? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Is the date on RISC accurate with no backdating?
                </label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q25_answer"
                                value="1"
                                name="individual_q25_answer"
                                id="individual_q25_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q25_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q25_answer"
                                value="2"
                                name="individual_q25_answer"
                                id="individual_q25_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q25_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q25_answer"
                                value="3"
                                name="individual_q25_answer"
                                id="individual_q25_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q25_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q25_danger"
                            id="individual_q25_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q25_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q25_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q25_comment" id="individual_q1_comment"
                          name.lazy="individual_q25_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- Are all contracts signed by customer(s)?? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are all contracts signed by customer(s)?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q26_answer"
                                value="1"
                                name="individual_q26_answer"
                                id="individual_q26_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q26_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q26_answer"
                                value="2"
                                name="individual_q26_answer"
                                id="individual_q26_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q26_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q26_answer"
                                value="3"
                                name="individual_q26_answer"
                                id="individual_q26_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q26_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q26_danger"
                            id="individual_q26_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q26_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q26_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q26_comment" id="individual_q1_comment"
                          name.lazy="individual_q26_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- All signature match up between menu, buyers order, RISC and all other product contracts? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">All signature match up between menu, buyers order,
                    RISC and all other product contracts?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q27_answer"
                                value="1"
                                name="individual_q27_answer"
                                id="individual_q27_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q27_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q27_answer"
                                value="2"
                                name="individual_q27_answer"
                                id="individual_q27_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q27_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q27_answer"
                                value="3"
                                name="individual_q27_answer"
                                id="individual_q27_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q27_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q27_danger"
                            id="individual_q27_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q27_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q27_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q27_comment" id="individual_q1_comment"
                          name.lazy="individual_q27_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- Is there a copy of customers Driver's License in deal? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Is there a copy of customers Driver's License in
                    deal?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q28_answer"
                                value="1"
                                name="individual_q28_answer"
                                id="individual_q28_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q28_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q28_answer"
                                value="2"
                                name="individual_q28_answer"
                                id="individual_q28_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q28_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q28_answer"
                                value="3"
                                name="individual_q28_answer"
                                id="individual_q28_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q28_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q28_danger"
                            id="individual_q28_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q28_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q28_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q28_comment" id="individual_q1_comment"
                          name.lazy="individual_q28_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- Language of contracts given to customers proper for negotiaition if required by state law? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Language of contracts given to customers proper for
                    negotiation if required by state law?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q29_answer"
                                value="1"
                                name="individual_q29_answer"
                                id="individual_q29_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q29_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q29_answer"
                                value="2"
                                name="individual_q29_answer"
                                id="individual_q29_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q29_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q29_answer"
                                value="3"
                                name="individual_q29_answer"
                                id="individual_q29_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q29_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q29_danger"
                            id="individual_q29_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q29_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q29_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q29_comment" id="individual_q1_comment"
                          name.lazy="individual_q29_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- Are all state specific disclosures included in deal? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Are all state specific disclosures included in
                    deal?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q30_answer"
                                value="1"
                                name="individual_q30_answer"
                                id="individual_q30_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q30_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q30_answer"
                                value="2"
                                name="individual_q30_answer"
                                id="individual_q30_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q30_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q30_answer"
                                value="3"
                                name="individual_q30_answer"
                                id="individual_q30_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q30_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q30_danger"
                            id="individual_q30_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q30_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q30_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q30_comment" id="individual_q1_comment"
                          name.lazy="individual_q34_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- Is Cosigner Notice sign? (if applicable) -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Is Cosigner Notice sign? (if applicable)</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q31_answer"
                                value="1"
                                name="individual_q31_answer"
                                id="individual_q31_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q31_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q31_answer"
                                value="2"
                                name="individual_q31_answer"
                                id="individual_q31_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q31_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q31_answer"
                                value="3"
                                name="individual_q31_answer"
                                id="individual_q31_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q31_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q31_danger"
                            id="individual_q31_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q31_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q31_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q31_comment" id="individual_q1_comment"
                          name.lazy="individual_q31_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- If there is a cashed deferred payment "Promissory Note from Customer" made, is it properly disclosed? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">If there is a cashed deferred payment "Promissory
                    Note from Customer" made, is it properly disclosed?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q32_answer"
                                value="1"
                                name="individual_q32_answer"
                                id="individual_q32_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q32_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q32_answer"
                                value="2"
                                name="individual_q32_answer"
                                id="individual_q32_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q32_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q32_answer"
                                value="3"
                                name="individual_q32_answer"
                                id="individual_q32_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q32_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q32_danger"
                            id="individual_q32_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q32_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q32_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q32_comment" id="individual_q1_comment"
                          name.lazy="individual_q32_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- Was the "Cashed Deferred" down payment paid off before the 2nd scheduled payment period? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Was the "Cashed Deferred" down payment paid off
                    before the 2nd scheduled payment period?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q33_answer"
                                value="1"
                                name="individual_q33_answer"
                                id="individual_q33_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q33_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q33_answer"
                                value="2"
                                name="individual_q33_answer"
                                id="individual_q33_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q33_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q33_answer"
                                value="3"
                                name="individual_q33_answer"
                                id="individual_q33_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q33_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q33_danger"
                            id="individual_q33_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q33_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q33_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q33_comment" id="individual_q1_comment"
                          name.lazy="individual_q33_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- Is the Deal Recap or reconcillation documents reviewed and in file? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Is the Deal Recap or reconciliation documents
                    reviewed and in file?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q34_answer"
                                value="1"
                                name="individual_q34_answer"
                                id="individual_q34_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q34_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q34_answer"
                                value="2"
                                name="individual_q34_answer"
                                id="individual_q34_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q34_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q34_answer"
                                value="3"
                                name="individual_q34_answer"
                                id="individual_q34_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q34_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q34_danger"
                            id="individual_q34_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q34_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q34_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q34_comment" id="individual_q1_comment"
                          name.lazy="individual_q34_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- Was the 8300 procedures followed for transactions defined as "CASH"? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Was the 8300 procedures followed for transactions
                    defined as "CASH"?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q35_answer"
                                value="1"
                                name="individual_q35_answer"
                                id="individual_q35_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q35_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q35_answer"
                                value="2"
                                name="individual_q35_answer"
                                id="individual_q35_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q35_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q35_answer"
                                value="3"
                                name="individual_q35_answer"
                                id="individual_q35_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q35_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q35_danger"
                            id="individual_q35_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q35_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q35_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q35_comment" id="individual_q1_comment"
                          name.lazy="individual_q35_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- Was there a receipt for any cash down payments in deal? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Was there a receipt for any cash down payments in
                    deal?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q36_answer"
                                value="1"
                                name="individual_q36_answer"
                                id="individual_q36_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q36_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q36_answer"
                                value="2"
                                name="individual_q36_answer"
                                id="individual_q36_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q36_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q36_answer"
                                value="3"
                                name="individual_q36_answer"
                                id="individual_q36_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q36_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q36_danger"
                            id="individual_q36_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q36_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q36_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q36_comment" id="individual_q1_comment"
                          name.lazy="individual_q36_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- Was the trade in vehicle properly disclosed (line itemed) on the buyers order and RISC? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Was the trade in vehicle properly disclosed (line
                    itemed) on the buyers order and RISC?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q37_answer"
                                value="1"
                                name="individual_q37_answer"
                                id="individual_q37_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q37_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q37_answer"
                                value="2"
                                name="individual_q37_answer"
                                id="individual_q37_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q37_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q37_answer"
                                value="3"
                                name="individual_q37_answer"
                                id="individual_q37_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q37_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q37_danger"
                            id="individual_q37_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q37_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q37_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q37_comment" id="individual_q1_comment"
                          name.lazy="individual_q37_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- Lease deal contract properly displaying all products purchased? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Lease deal contract properly displaying all
                    products purchased?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q38_answer"
                                value="1"
                                name="individual_q38_answer"
                                id="individual_q38_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q38_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q38_answer"
                                value="2"
                                name="individual_q38_answer"
                                id="individual_q38_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q38_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q38_answer"
                                value="3"
                                name="individual_q38_answer"
                                id="individual_q38_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q38_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q38_danger"
                            id="individual_q38_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q38_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q38_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q38_comment" id="individual_q1_comment"
                          name.lazy="individual_q38_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- Is it clear what the customer purchased and did the deal reflect the norm in the dealership? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Is it clear what the customer purchased and did the
                    deal reflect the norm in the dealership?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q39_answer"
                                value="1"
                                name="individual_q39_answer"
                                id="individual_q39_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q39_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q39_answer"
                                value="2"
                                name="individual_q39_answer"
                                id="individual_q39_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q39_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q39_answer"
                                value="3"
                                name="individual_q39_answer"
                                id="individual_q39_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q39_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q39_danger"
                            id="individual_q39_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q39_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q39_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q39_comment" id="individual_q1_comment"
                          name.lazy="individual_q39_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- Is the deal jacket complete with all information required based on the customer needs and wants? -->
        <div class="bg-gray-50 p-3 space-y-7">
            <div>
                <label class="text-base font-semibold text-gray-900">Is the deal jacket complete with all information
                    required based on the customer needs and wants?</label>
                <fieldset class="mt-4">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q40_answer"
                                value="1"
                                name="individual_q40_answer"
                                id="individual_q40_answer_1"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q40_answer_1"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q40_answer"
                                value="2"
                                name="individual_q40_answer"
                                id="individual_q40_answer_2"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q40_answer_2"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="individual_q40_answer"
                                value="3"
                                name="individual_q40_answer"
                                id="individual_q40_answer_3"
                                type="radio"
                                class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                            >
                            <label for="individual_q40_answer_3"
                                   class="ml-3 block text-sm font-medium leading-6 text-gray-900">N/A</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <label>
                        <input
                            wire:model="individual_q40_danger"
                            id="individual_q40_danger"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600"
                        />
                    </label>
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="individual_q40_danger" class="font-medium text-red-500">Flag as high risk</label>
                </div>
            </div>
            <div>
                <label for="individual_q40_comment" class="text-base font-semibold text-gray-900">Comments</label>
                <textarea wire:model.lazy="individual_q40_comment" id="individual_q1_comment"
                          name.lazy="individual_q40_comment"
                          rows="3"
                          class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"></textarea>
            </div>
        </div>
        <!-- Images -->
        <x-media-library-collection
            multiple
            max-items="6"
            rules="mimes:png,jpeg"
            name="audit_images"
            :model="$individualAudit"
            collection="individual_audit_images"
        />
        {{--        Sticky Save Bar--}}
        <div class="w-full sticky bottom-0 bg-arm-blue-200 p-5 z-20">
            <div class="flex justify-between sm:justify-end items-center flex-row-reverse sm:flex-row">
                <a
                    class="sm:mr-auto ml-5 sm:ml-0 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                    href="{{ !tenant('locations') ? route('dealer.audit.individual.show', $parent) : route('dealer.stores.audits.individual.show', [$store, $parent]) }}"
                >
                    Exit
                </a>
                <button
                    wire:click.prevent="uploadImages"
                    class="inline-flex items-center px-4 py-2 bg-arm-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-arm-blue-700 focus:bg-arm-blue-700 active:bg-arm-blue-900 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                >
                    <svg wire:loading
                         class="animate-spin w-4 h-4 mr-2 text-gray-300 hover:cursor-pointer"
                         xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Update
                </button>
                <div class="relative flex items-start mr-auto sm:mr-0 sm:ml-5">
                    <div class="flex h-6 items-center">
                        <input wire:model="draft" id="draft" aria-describedby="draft-description" name="draft"
                               type="checkbox"
                               class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                    </div>
                    <div class="ml-1 text-sm leading-6">
                        <label for="draft" class="font-medium text-gray-900">Save as Draft</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Loading Modal -->
    <div wire:loading.delay class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-100 bg-opacity-75 transition-opacity"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div
                    class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
                    <div>
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                            <svg class="animate-spin h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-5">
                            <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Audit
                                Saving</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">This may take a few seconds, please don't close this
                                    page.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
