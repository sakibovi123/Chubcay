import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import DeleteUserForm from './Partials/DeleteUserForm';
import UpdatePasswordForm from './Partials/UpdatePasswordForm';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm';
import { Head } from '@inertiajs/react';
import Header from '@/Components/Main/Header';

export default function Edit({ auth, mustVerifyEmail, status }) {
    return (
        // <AuthenticatedLayout
        //     user={auth.user}
        //     header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Profile</h2>}
        // >
        //     <Head title="Profile" />

        //     <div className="py-12">
        //         <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        //             <div className="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        //                 <UpdateProfileInformationForm
        //                     mustVerifyEmail={mustVerifyEmail}
        //                     status={status}
        //                     className="max-w-xl"
        //                 />
        //             </div>

        //             <div className="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        //                 <UpdatePasswordForm className="max-w-xl" />
        //             </div>

        //             <div className="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        //                 <DeleteUserForm className="max-w-xl" />
        //             </div>
        //         </div>
        //     </div>
        // </AuthenticatedLayout>
        
        <div className="w-full container md:mx-auto">
            <Head title='Profile' />
            <Header />

            <div className="my-[4rem] w-[50%] bg-white border rounded p-3">

            </div>

        </div>
    );
}
