<div class="px-6 pt-6">
    <p class="text-lg text-arm-blue-400 mb-3">Overall grades based on all stores in your group.</p>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="border rounded-md flex flex-col justify-center items-center py-10">
            <p class="text-center text-3xl">
                Overall <span class="block font-black text-7xl text-arm-blue-800">{{ $rating ?? '-' }}</span>
            </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="border rounded-md flex flex-col justify-center items-center py-10">
                <p class="text-center">
                    OSHA <span class="block font-black text-7xl text-arm-blue-800">{{ $this->oshaRating ?? '-' }}</span>
                </p>
            </div>
            <div class="border rounded-md flex flex-col justify-center items-center py-10">
                <p class="text-center">
                    Deal Jackets <span class="block font-black text-7xl text-arm-blue-800">{{ $this->dealJacketRating ?? '-' }}</span>
                </p>
            </div>
            <div class="border rounded-md flex flex-col justify-center items-center py-10">
                <p class="text-center">
                    GLBA <span class="block font-black text-7xl text-arm-blue-800">{{ $this->glbaRating ?? '-' }}</span>
                </p>
            </div>
            <div class="border rounded-md flex flex-col justify-center items-center py-10">
                <p class="text-center">
                    Body Shop <span class="block font-black text-7xl text-arm-blue-800">{{ $this->bodyShopRating ?? '-' }}</span>
                </p>
            </div>
        </div>
    </div>
</div>
