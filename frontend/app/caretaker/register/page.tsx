"use client";

import { useEffect } from "react";
import { zodResolver } from "@hookform/resolvers/zod";
import { useForm, Controller } from "react-hook-form";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { RegisterFormValues, RegisterSchema } from "@/types/schema";
import { ReusableForm } from "@/components/ReusableForm";
import { ReusableSelect } from "@/components/ReusableSelect";
import { Button } from "@/components/ui/button";
import { useRegister } from "@/hooks/useCaretakerMutation";
// import { useOtpTimer } from '@/hooks/useOtpTimer';
import {
  useGetProfile,
  useSendOtpRequest,
  useVerifyOtp,
} from "@/hooks/useAuthMutations";
import PhoneInputField from "@/components/PhoneInputField";
import { Loader2 } from "lucide-react";

export default function RegisterPage() {
  const { mutate, isPending } = useRegister();
  const { data } = useGetProfile();

  // const sendOtp = useSendOtpRequest();
  // const verifyOtp = useVerifyOtp();
  // const otpTimer = useOtpTimer(120);
  // const [isPhoneVerified, setIsPhoneVerified] = useState<boolean>(
  //     !!data?.user?.phone
  // );

  const userPhone = data?.user?.phone;
  const country = data?.user?.country;
  // const secondsLeft = otpTimer.secondsLeft;

  // const showSendOtpBtn = !userPhone;
  // const showOtpInput = secondsLeft > 0 && !userPhone;
  // const showOtpTimer = secondsLeft > 0;

  // const isSendDisabled =
  //     !otpTimer.canResend || sendOtp.isPending || isPhoneVerified;

  // const isPhoneDisabled = userPhone || isPhoneVerified;

  const form = useForm<RegisterFormValues>({
    resolver: zodResolver(RegisterSchema),
    defaultValues: {
      patient: {
        fullname: "",
        dateOfBirth: "",
        gender: "",
      },
      fullname: "",
      email: data?.user?.email || "",
      relationship: "",
      country: country || "",
      city: "",
      pincode: "",
      phone: userPhone || "",
      otp: "",
    },
  });

  /** Send OTP */
  // const handleSendOtp = async () => {
  //     const identifier = form.getValues("phone");

  //     const isValid = await form.trigger("phone");
  //     if (!isValid) return;

  //     sendOtp.mutate(
  //         { identifier },
  //         {
  //             onSuccess: () => otpTimer.start(),
  //         }
  //     );
  // };

  const onSubmit = (values: RegisterFormValues) => {
    mutate({
      ...values,
      relationship:
        values.relationship === "other"
          ? values.relationshipOther?.trim()
          : values.relationship,
      patient: {
        ...values.patient,
        // gender:
        //     values.patient.gender === "other"
        //         ? values.patient.genderOther?.trim()
        //         : values.patient.gender,
      },
    });
  };

  // const handleVerifyOtp = () => {
  //     const phone = form.getValues("phone");
  //     const otp = form.getValues("otp");

  //     verifyOtp.mutate(
  //         { phone, otp: otp as string },
  //         {
  //             onSuccess: () => {
  //                 setIsPhoneVerified(true);
  //                 otpTimer.reset();
  //             },
  //         }
  //     );
  // };

  useEffect(() => {
    if (!data) return;

    form.setValue("email", data?.user?.email ?? "");
    form.setValue("phone", data?.user?.phone ?? "");
    // form.setValue("country", data?.user?.country ?? "");

    // if (data?.user?.phone) {
    //     setIsPhoneVerified(true);
    // }
  }, [data?.user, form]);

  return (
    <div className="min-h-screen flex items-center justify-center md:py-5 bg-white md:bg-gray-100">
      <ReusableForm
        heading="Medicine Recipient Details"
        subHeading="Enter medicine details as mentioned in the prescription for verification"
        form={form}
        onSubmit={onSubmit}
      >
        {/* -------- PATIENT SECTION -------- */}

        <div className="space-y-2">
          <Label className="font-medium pl-1">
            Medicine Recipient Full Name
          </Label>
          <Input
            {...form.register("patient.fullname")}
            placeholder="Enter Medicine recipient's full name (as per ID)"
            maxLength={30}
            allowPattern={/[^A-Za-z -]/g}
            className="capitalize"
          />
          {form.formState.errors.patient?.fullname && (
            <p className="text-red-500 text-sm">
              {form.formState.errors.patient.fullname.message}
            </p>
          )}
        </div>

        <div className="grid grid-cols-2 gap-4 w-full">
          <div className="space-y-2">
            <Label className="font-medium pl-1">Date of Birth</Label>
            <Input
              type="date"
              max="9999-12-31"
              min="1900-01-01"
              {...form.register("patient.dateOfBirth")}
            />
            {form.formState.errors.patient?.dateOfBirth && (
              <p className="text-red-500 text-sm">
                {form.formState.errors.patient.dateOfBirth.message}
              </p>
            )}
          </div>

          <div className="space-y-2">
            <Controller
              control={form.control}
              name="patient.gender"
              render={({ field }) => (
                <ReusableSelect
                  label="Gender"
                  placeholder="Select gender"
                  value={field.value}
                  onChange={(value) => {
                    field.onChange(value);

                    // clear manual value if user switches from "other"
                    // if (value !== "other") {
                    //     form.setValue("patient.genderOther", "");
                    //     form.clearErrors("patient.genderOther");
                    // }
                  }}
                  options={[
                    { label: "Male", value: "male" },
                    { label: "Female", value: "female" },
                    { label: "Other", value: "other" },
                  ]}
                />
              )}
            />

            {/* Show input only when "other" is selected */}
            {/* {form.watch("patient.gender") === "other" && (
                            <Input
                                placeholder="Enter gender"
                                {...form.register("patient.genderOther", {
                                    required: "Please specify gender",
                                })}
                                autoFocus
                                maxLength={30}
                                allowPattern={/[^A-Za-z]/g}
                            />
                        )} */}

            {form.formState.errors.patient?.gender && (
              <p className="text-red-500 text-sm">
                {form.formState.errors.patient?.gender?.message ||
                  form.formState.errors.patient?.message}
              </p>
            )}
          </div>
        </div>

        {/* -------- CARETAKER SECTION -------- */}

        <div className="flex items-center w-full gap-3 mt-8">
          <span className="w-full border border-gray-400"></span>
          <p className="w-full text-nowrap font-light text-sm">
            Caretaker Contact Details
          </p>
          <span className="w-full border border-gray-400"></span>
        </div>

        <div className="space-y-2">
          <Label className="font-medium pl-1">Caretaker Full Name</Label>
          <Input
            {...form.register("fullname")}
            placeholder="Enter full name (as per ID)"
            maxLength={30}
            allowPattern={/[^A-Za-z -]/g}
            className="capitalize"
          />
          {form.formState.errors.fullname && (
            <p className="text-red-500 text-sm">
              {form.formState.errors.fullname.message}
            </p>
          )}
        </div>

        <div className="space-y-2">
          <Label className="font-medium pl-1">Email ( Optional )</Label>
          <Input
            {...form.register("email")}
            disabled={data?.user?.email}
            placeholder="Enter email address "
            allowPattern={/[^a-zA-Z0-9@._-]/g}
            maxLength={50}
          />
        </div>

        <div className="grid grid-cols-2 gap-4 w-full">
          <div className="space-y-2">
            <Controller
              control={form.control}
              name="relationship"
              render={({ field }) => (
                <ReusableSelect
                  label="Relationship"
                  placeholder="Select"
                  value={field.value}
                  onChange={(value) => {
                    field.onChange(value);

                    // clear manual value if user switches from "other"
                    if (value !== "other") {
                      form.setValue("relationshipOther", "");
                      form.clearErrors("relationshipOther");
                    }
                  }}
                  options={[
                    { label: "Father", value: "father" },
                    { label: "Mother", value: "mother" },
                    { label: "Sibling", value: "sibling" },
                    { label: "Spouse", value: "spouse" },
                    { label: "Child", value: "child" },
                    { label: "Other", value: "other" },
                  ]}
                />
              )}
            />

            {/* Show input only when "other" is selected */}
            {form.watch("relationship") === "other" && (
              <Input
                placeholder="Enter relationship"
                {...form.register("relationshipOther", {
                  required: "Please specify the relationship",
                })}
                autoFocus
                maxLength={30}
                allowPattern={/[^A-Za-z ]/g}
              />
            )}

            {(form.formState.errors.relationship ||
              form.formState.errors.relationshipOther) && (
              <p className="text-red-500 text-sm">
                {form.formState.errors.relationship?.message ||
                  form.formState.errors.relationshipOther?.message}
              </p>
            )}
          </div>

          <div className="space-y-2">
            <Label className="font-medium pl-1">Country</Label>
            <Input
              {...form.register("country")}
              placeholder="Enter country name"
              maxLength={30}
              allowPattern={/[^A-Za-z -]/g}
              className="capitalize"
            />
            {form.formState.errors.country && (
              <p className="text-red-500 text-sm">
                {form.formState.errors.country.message}
              </p>
            )}
          </div>
        </div>

        <div className="grid grid-cols-2 gap-4 w-full">
          <div className="space-y-2">
            <Label className="font-medium pl-1">City</Label>
            <Input
              {...form.register("city")}
              placeholder="Enter city name"
              maxLength={30}
              allowPattern={/[^A-Za-z -]/g}
              className="capitalize"
            />
            {form.formState.errors.city && (
              <p className="text-red-500 text-sm">
                {form.formState.errors.city.message}
              </p>
            )}
          </div>
          <div className="space-y-2">
            <Label className="font-medium pl-1">Pin Code</Label>
            <Input
              {...form.register("pincode")}
              placeholder="Enter pincode"
              maxLength={15}
              allowPattern={/[^0-9-]/}
              className="capitalize"
            />
            {form.formState.errors.pincode && (
              <p className="text-red-500 text-sm">
                {form.formState.errors.pincode.message}
              </p>
            )}
          </div>
        </div>

        <div className="space-y-2">
          <Label className="font-medium pl-1">Phone Number</Label>
          {/* <div className="flex justify-between items-center">
                        {showSendOtpBtn && (
                            <button
                                type="button"
                                className="text-sm text-primary disabled:opacity-50 cursor-pointer"
                                disabled={isSendDisabled}
                                onClick={handleSendOtp}
                            >
                                {sendOtp.isPending ? <Loader /> : "Send OTP"}
                            </button>
                        )}
                    </div> */}
          {country === "IN" ? (
            <Input value={userPhone} disabled />
          ) : (
            <PhoneInputField
              type="phone"
              value={form.watch("phone") as string}
              // disabled={isPhoneDisabled}
              onChange={(value) =>
                form.setValue("phone", value, { shouldValidate: true })
              }
            />
          )}
        </div>

        <Button
          type="submit"
          className="w-full mt-5 py-6 text-xl font-medium "
          disabled={
            isPending
            // ||
            // verifyOtp.isPending ||
            // !isPhoneVerified
          }
        >
          {isPending ? (
            <span className="flex items-center justify-center gap-2">
              <Loader2 className="h-4 w-4 animate-spin" />
              Processing...
            </span>
          ) : (
            "Continue"
          )}
        </Button>
      </ReusableForm>
    </div>
  );
}

// {/* Phone input */}
//             {!userPhone ? (
//                 <PhoneInputField
//                     type='phone'
//                     value={form.watch("phone")}
//                     disabled={isPhoneDisabled}
//                     onChange={(value) =>
//                         form.setValue("phone", value, { shouldValidate: true })
//                     }
//                 />
//             ) : (
//                 <Input value={userPhone} disabled />
//             )}

//             {/* OTP input */}
//             {showOtpInput && (
//                 <div className="flex items-center w-full gap-3 mt-2">
//                     <Input
//                         {...form.register("otp")}
//                         placeholder="Enter OTP"
//                         allowPattern={/[^0-9]/g}
//                     />

//                     <Button
//                         type="button"
//                         onClick={handleVerifyOtp}
//                         disabled={verifyOtp.isPending}
//                     >
//                         {verifyOtp.isPending ? "Verifying..." : "Verify OTP"}
//                     </Button>
//                 </div>
//             )}

//             {/* OTP timer */}
//             {showOtpTimer && (
//                 <div className="w-full flex justify-end">
//                     <span className="text-xs text-muted-foreground">
//                         OTP resend in {Math.floor(secondsLeft / 60)}:
//                         {(secondsLeft % 60).toString().padStart(2, "0")} min
//                     </span>
//                 </div>
//             )}

//             {/* Error */}
//             {form.formState.errors.phone && (
//                 <p className="text-red-600 text-sm pl-1">
//                     {form.formState.errors.phone.message}
//                 </p>
//             )}
