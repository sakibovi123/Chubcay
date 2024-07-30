import ApplicationLogo from '@/Components/ApplicationLogo';
import Header from '@/Components/Main/Header';
import { Link } from '@inertiajs/react';

export default function Guest({ children }) {
    return (
     
 
        <div className="container md:mx-auto min-h-screen flex flex-col bg-gray-100">
            <Header />

            <div className="flex-grow flex flex-col items-center justify-center w-full">
                <div className="container md:mx-auto lg:w-[80%] md:w-[60%] w-full">
                    <div className="flex flex-col items-center">
                        <h1 className="text-2xl font-bold text-center">Chubcay</h1>

                        <div className="w-full sm:max-w-md mt-6 px-7 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                            {children}
                        </div>
                    </div>
                </div>
            </div>
        </div>



        
    );
}
